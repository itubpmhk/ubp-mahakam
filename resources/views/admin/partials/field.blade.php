{{--
  Reusable form field.
  @include('admin.partials.field', ['name' => 'title', 'label' => 'Judul', 'value' => $x, 'type' => 'text|textarea|url|email|number', 'help' => '...', 'rows' => 3, 'required' => true])
--}}
@php
  $type = $type ?? 'text';
  $val = old($name, $value ?? '');
  $id = 'f_'.str_replace(['[', ']', '.'], '_', $name);
@endphp
<div class="field {{ $class ?? '' }}">
  <label for="{{ $id }}">{{ $label }}@if (!empty($required)) <i>*</i>@endif</label>
  @if ($type === 'textarea')
    <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows ?? 3 }}" @if (!empty($required)) required @endif @if (!empty($max)) maxlength="{{ $max }}" @endif>{{ $val }}</textarea>
  @else
    <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" value="{{ $val }}" @if (!empty($required)) required @endif
           @if (!empty($placeholder)) placeholder="{{ $placeholder }}" @endif @if (!empty($max)) maxlength="{{ $max }}" @endif>
  @endif
  @if (!empty($help))<small>{{ $help }}</small>@endif
  @error($name)<em class="ferr">{{ $message }}</em>@enderror
</div>
