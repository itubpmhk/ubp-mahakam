// Runs after `vite build`: obfuscates our own JavaScript in public/build/assets.
// vendor-*.js (three.js, lenis, trix) is left alone: it is public anyway and obfuscating it only slows the site.
import { readdir, readFile, writeFile } from 'node:fs/promises';
import { join } from 'node:path';
import JavaScriptObfuscator from 'javascript-obfuscator';

const dir = 'public/build/assets';
const files = (await readdir(dir)).filter((f) => f.endsWith('.js') && !f.startsWith('vendor'));

for (const f of files) {
  const path = join(dir, f);
  const code = await readFile(path, 'utf8');
  const result = JavaScriptObfuscator.obfuscate(code, {
    target: 'browser',
    compact: true,
    identifierNamesGenerator: 'hexadecimal',
    renameGlobals: false,
    stringArray: true,
    stringArrayEncoding: ['base64'],
    stringArrayThreshold: 0.75,
    splitStrings: true,
    splitStringsChunkLength: 8,
    transformObjectKeys: true,
    numbersToExpressions: true,
    // these make code much slower; the 3D loop runs every frame, so keep them off
    controlFlowFlattening: false,
    deadCodeInjection: false,
    selfDefending: false,
    sourceMap: false,
  });
  await writeFile(path, result.getObfuscatedCode());
  console.log('obfuscated', f);
}
