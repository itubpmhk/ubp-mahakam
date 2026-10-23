<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Keeps only safe formatting tags from the news editor (Trix) output.
 * Anything else (script, style, iframe, event handlers, javascript: links ...) is removed,
 * so news text can be printed as HTML on the public site without XSS risk.
 */
class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'div', 'br', 'strong', 'b', 'em', 'i', 'u', 'del', 's', 'strike',
        'a', 'h1', 'h2', 'h3', 'h4', 'blockquote', 'pre', 'code', 'ul', 'ol', 'li', 'hr',
        'figure', 'figcaption', 'img',
    ];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="__root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $root = $doc->getElementById('__root');
        if (! $root) {
            return e(strip_tags($html));
        }
        self::walk($root);

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        return trim($out);
    }

    private static function walk(DOMNode $node): void
    {
        // iterate over a static copy because we modify the tree
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'textarea', 'select', 'button', 'svg', 'math', 'template'], true)) {
                    $child->parentNode->removeChild($child);
                    continue;
                }

                self::walk($child);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    // unwrap: keep the text/children, drop the tag itself
                    while ($child->firstChild) {
                        $child->parentNode->insertBefore($child->firstChild, $child);
                    }
                    $child->parentNode->removeChild($child);
                    continue;
                }

                self::cleanAttributes($child, $tag);
            } elseif ($child->nodeType === XML_COMMENT_NODE || $child->nodeType === XML_PI_NODE) {
                $child->parentNode->removeChild($child);
            }
        }
    }

    private static function cleanAttributes(DOMElement $el, string $tag): void
    {
        $href = $tag === 'a' ? trim($el->getAttribute('href')) : null;
        $src = $tag === 'img' ? trim($el->getAttribute('src')) : null;
        $alt = $tag === 'img' ? $el->getAttribute('alt') : null;
        $width = $tag === 'img' ? $el->getAttribute('width') : null;
        $height = $tag === 'img' ? $el->getAttribute('height') : null;

        foreach (iterator_to_array($el->attributes) as $attr) {
            $el->removeAttribute($attr->nodeName);
        }

        if ($tag === 'img') {
            // only pictures uploaded to this site (/storage/...) or https images
            if ($src === null || ! preg_match('~^(/storage/|https://)~i', $src)) {
                $el->parentNode?->removeChild($el);

                return;
            }
            $el->setAttribute('src', $src);
            $el->setAttribute('alt', mb_substr((string) $alt, 0, 200));
            $el->setAttribute('loading', 'lazy');
            if (ctype_digit((string) $width) && ctype_digit((string) $height)) {
                $el->setAttribute('width', $width);
                $el->setAttribute('height', $height);
            }

            return;
        }

        if ($tag === 'figure') {
            // Rebuild (never copy) Trix's attachment data so the picture stays an
            // editable attachment, with its caption, when the post is opened again.
            $img = $el->getElementsByTagName('img')->item(0);
            if ($img) {
                $cap = $el->getElementsByTagName('figcaption')->item(0);
                $data = ['contentType' => 'image', 'url' => $img->getAttribute('src')];
                if ($cap && trim($cap->textContent) !== '') {
                    $data['caption'] = trim($cap->textContent);
                }
                $el->setAttribute('data-trix-attachment', json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                $el->setAttribute('data-trix-content-type', 'image');
                $el->setAttribute('class', 'attachment attachment--preview');
            }

            return;
        }

        if ($tag === 'a') {
            if ($href !== null && preg_match('~^(https?://|mailto:|tel:|/|#)~i', $href)) {
                $el->setAttribute('href', $href);
                if (preg_match('~^https?://~i', $href)) {
                    $el->setAttribute('target', '_blank');
                    $el->setAttribute('rel', 'noopener noreferrer');
                }
            }
        }
    }
}
