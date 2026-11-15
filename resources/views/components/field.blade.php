@props(['name','label','type'=>'text','value'=>null,'options'=>null,'required'=>false])
<div class="field"><label for="{{ $name }}">{{ $label }}</label>
@if($options!==null)<select id="{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes }}><option value="">Pilih {{ strtolower($label) }}</option>@foreach($options as $key=>$text)<option value="{{ $key }}" @selected((string)old($name,$value)===(string)$key)>{{ $text }}</option>@endforeach</select>
@elseif($type==='textarea')<textarea id="{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes }}>{{ old($name,$value) }}</textarea>
@elseif($type==='password')<div class="password-field"><input id="{{ $name }}" type="password" name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes }}><button type="button" data-password="{{ $name }}" aria-label="Tampilkan kata sandi"><i data-lucide="eye"></i></button></div>
@else<input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" @if($type!=='file') value="{{ old($name,$value) }}" @endif {{ $required ? 'required' : '' }} {{ $attributes }}>@endif
@error($name)<small class="error" role="alert">{{ $message }}</small>@enderror</div>
