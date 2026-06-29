<?php
/**
 * Custom range control — renders a slider + number input in sync.
 * The number input carries the WP Customize setting link so both
 * inputs update the setting and trigger postMessage live preview.
 *
 * @package Axiom\Customizer
 */

declare( strict_types=1 );

namespace Axiom\Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Range_Control extends \WP_Customize_Control {

	public $type = 'axiom-range';
	public string $unit = '';

	public function render_content(): void {
		$attrs = $this->input_attrs + [ 'min' => 0, 'max' => 100, 'step' => 1 ];
		$val   = $this->value();
		?>
		<?php if ( $this->label ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>
		<?php if ( $this->description ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<div class="axiom-range-wrap">
			<input
				type="range"
				class="axiom-range-slider"
				min="<?php echo esc_attr( (string) $attrs['min'] ); ?>"
				max="<?php echo esc_attr( (string) $attrs['max'] ); ?>"
				step="<?php echo esc_attr( (string) $attrs['step'] ); ?>"
				value="<?php echo esc_attr( $val ); ?>"
				aria-hidden="true"
				tabindex="-1"
			>
			<input
				type="number"
				class="axiom-range-number"
				min="<?php echo esc_attr( (string) $attrs['min'] ); ?>"
				max="<?php echo esc_attr( (string) $attrs['max'] ); ?>"
				step="<?php echo esc_attr( (string) $attrs['step'] ); ?>"
				value="<?php echo esc_attr( $val ); ?>"
				<?php $this->link(); ?>
			>
			<?php if ( $this->unit ) : ?>
				<span class="axiom-range-unit"><?php echo esc_html( $this->unit ); ?></span>
			<?php endif; ?>
		</div>
		<?php
	}
}
