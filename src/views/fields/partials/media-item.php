<li class="masonry-item masonry-item-inline-media">
	<input type="checkbox" class="media-is-used" data-bind="
		checked: selected,
		value: id,
		attr: { 
			id: $parent.fieldId + '-' + id,
			name: 'media[' + $index() + '][id]'
		}
	">
	<label data-bind="attr: { for: $parent.fieldId + '-' + id }">
		<img data-bind="attr: { src: $parent.getFilename(filename) }" width="150">
		<p class="icons" data-bind="text: caption"></p>
		<select data-bind="
			attr: { name: 'media[' + $index() + '][alias]' },
			options: $parents[1].aliases,
			value: alias
		"></select>
	</label>
</li>
