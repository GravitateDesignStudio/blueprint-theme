<?php
namespace Blueprint;

abstract class Blocks
{
	protected static $bg_colors;

	/**
	 * Enforce background color choices
	 *
	 * @param array $new_colors Key (class name) / Value (color name) pair.
	 * @return void
	 */
	public static function enforce_background_colors(array $new_colors): void
	{
		if (!is_array($new_colors)) {
			return;
		}

		self::$bg_colors = $new_colors;

		add_filter('grav_block_background_colors', function ($colors) use (&$new_colors) {
			return $new_colors;
		});
	}

	public static function get_bg_colors(array $opts = []): array
	{
		if (!self::$bg_colors || !is_array(self::$bg_colors)) {
			return [];
		}

		$colors = array_filter(self::$bg_colors, function ($name, $class) use (&$opts) {
			if (isset($opts['exclude']) && is_array($opts['exclude']) && in_array($class, $opts['exclude'], true)) {
				return false;
			}

			return true;
		}, ARRAY_FILTER_USE_BOTH);

		return $colors;
	}

	/**
	 * Sort the order blocks appear in the flexible field dropdown list
	 * alphabetically
	 */
	public static function sort_block_names_alphabetically(): void
	{
		add_filter('grav_block_fields', function ($layouts) {
			uasort($layouts, function ($a, $b) {
				return strcasecmp($a['label'], $b['label']);
			});

			return $layouts;
		}, 1000);
	}

	/**
	 * Ensure the GRAV_BLOCKS::get_link_fields method can be called
	 * and return the resulting 'grav_link_fields' key
	 *
	 * @param array $params
	 * @return array
	 */
	public static function safe_get_link_fields(array $params): array
	{
		if (!class_exists('GRAV_BLOCKS')) {
			return [];
		}

		$fields = \GRAV_BLOCKS::get_link_fields($params);

		if (!is_array($fields) || !isset($fields['grav_link_fields'])) {
			return [];
		}

		return $fields['grav_link_fields'];
	}

	/**
	 * Ensure the GRAV_BLOCKS::display method can be called
	 *
	 * @param array $params
	 * @return void
	 */
	public static function safe_display(array $params = []): void
	{
		if (!class_exists('GRAV_BLOCKS')) {
			return;
		}

		\GRAV_BLOCKS::display($params);
	}

	/**
	 * Get the values for a button field created with the 'GRAV_BLOCKS::get_link_fields' method.
	 * Returns an object with 'text', 'link', and 'style' properties.
	 *
	 * @param string $acf_field
	 * @param int|array $object Can be a post ID or an array. Defaults to the current post ID.
	 * @return object
	 */
	public static function get_button_field_values(string $acf_field, $object = 0)
	{
		$button_values = (object)[
			'type' => '',
			'text' => '',
			'link' => '',
			'style' => ''
		];

		if (is_int($object)) {
			$post_id = $object ? $object : get_the_ID();
			$button_type = get_field($acf_field . '_type', $post_id) ?? 'none';

			if ($button_type !== 'none') {
				$button_values->type = $button_type;
				$button_values->text = get_field($acf_field . '_text', $post_id) ?? '';
				$button_values->link = get_field($acf_field . '_' . $button_type, $post_id) ?? '';
				$button_values->style = get_field($acf_field . '_style', $post_id) ?? '';
			}

		} else if (is_array($object)) {
			$button_type = $object[$acf_field . '_type'] ?? 'none';

			if ($button_type !== 'none') {
				$button_values->type = $button_type;
				$button_values->text = $object[$acf_field . '_text'] ?? '';
				$button_values->link = $object[$acf_field . '_' . $button_type] ?? '';
				$button_values->style = $object[$acf_field . '_style'] ?? '';
			}
		}

		return $button_values;
	}
}
