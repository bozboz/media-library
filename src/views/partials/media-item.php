<li class="masonry-item masonry-item-inline-media" data-id="{{ id }}" data-caption="{{ caption }}" data-filename="{{ filename }}">
	<?= Form::checkbox(
		'media[]',
		'{{ id }}',
		true,
		array('class'=> 'media-is-used', 'id' => '{{ ../fieldId }}-{{ id }}')
	) ?>
	<label for="{{ ../fieldId }}-{{ id }}">
		<img src="{{ filename }}" width="150">
		<p class="icons">{{ caption }}</p>
	</label>
</li>
