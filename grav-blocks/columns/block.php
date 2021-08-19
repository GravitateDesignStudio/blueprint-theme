<?php
use WPUtil\Vendor\ACF;
use WPUtil\Arrays;

$format = isset($format) && is_string($format) ? $format : ACF::get_sub_field_string('format');
$columns = isset($columns) && is_array($columns) ? $columns : ACF::get_sub_field_array('columns');

if ($columns) {
	$block_inner_attrs = [
		'class' => 'block-inner contain grid',
		'data-num-col' => count($columns),
		'data-format' => $format
	];

	?>
	<div <?php echo WPUtil\Util::attributes_array_to_string($block_inner_attrs); ?>>
		<?php
		foreach ($columns as $column)
		{
			$col_type = Arrays::get_value_as_string($column, 'type');

			?>
			<div class="block-columns__column wysiwyg">
				<?php
				switch ($col_type)
				{
					case 'wysiwyg':
						$wysiwyg_content = Arrays::get_value_as_string($column, 'wysiwyg');

						echo $wysiwyg_content;
						break;

					default:
						break;
				}
				?>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
