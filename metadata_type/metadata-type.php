<?php

/**
 * Class Cidades_BR_Metadata_type
 */
class Cidades_BR_Metadata_type extends \Tainacan\Metadata_Types\Metadata_Type {

	function __construct() {

		parent::__construct();

		// Basic options
		$this->set_name( 'Estado e Cidade' );
		$this->set_description( 'Estado e Cidade do Brasil com código do IBGE' );
		$this->set_primitive_type(['string']);
		$this->set_component('cidades-br-metadata-type');
		$this->set_preview_template('
			<div class="field">
				<div class="field-body">
					<div class="field is-grouped">
						<div class="control is-expanded">
							<span class="select is-fullwidth">
								<select><option value="52">	Goiás </option></select>
							</span>
						</div>
						<div class="control is-expanded">
							<span class="select is-fullwidth">
								<select><option value="5200050">Abadia de Goiás</option><option value="5200100">Abadiânia</option></select>
							</span>
						</div>
					</div>
				</div>
			</div>
		');

		// For custom Metadata Type Options
		// $this->set_form_component('tainacan-metadata-form-type-custom');
		// $this->set_default_options([
		//	 'step' => 1
		// ]);
	}

	/**
	* Gets a slug based on the class name to represent the metadata type
	*/
	public function get_slug() {
		$classname = get_class($this);
		return strtolower( substr($classname, strrpos($classname, '\\') + 1) );
	}
	
	public function get_value_as_html(\Tainacan\Entities\Item_Metadata_Entity $item_metadata) {
		
		$value = $item_metadata->get_value();
		$return = '';
		if ( $item_metadata->is_multiple() ) {
			$total = sizeof($value);
			$count = 0;
			$prefix = $item_metadata->get_multivalue_prefix();
			$suffix = $item_metadata->get_multivalue_suffix();
			$separator = $item_metadata->get_multivalue_separator();
			foreach ( $value as $el ) {
				if( empty( $el ) ) 
					continue;
				$return .= $prefix;
				$return .= $this->convert_code_to_string( $el );
				$return .= $suffix;
				$count ++;
				if ($count < $total)
					$return .= $separator;
			}
		} else {
			if( empty( $value ) )
				return "";
			$return = $this->convert_code_to_string( $value );
		}
		return $return;
		
	}
	
	public function convert_code_to_string( $code ) {
		global $cidades_brasileiras, $estados_brasileiros;

		if ( ! empty( $code ) ) {
			$cod_estado = substr( $code, 0, 2 );
			$cod_cidade = '0000';
			if ( strlen( $code ) > 2 ) {
				$cod_cidade = $code;
			}
			$nome_cidade = isset( $cidades_brasileiras->$cod_cidade ) ? $cidades_brasileiras->$cod_cidade . ' - ' : '';
			$nome_estado = isset( $estados_brasileiros->$cod_estado ) ? $estados_brasileiros->$cod_estado->sigla : '';

			$code = $nome_cidade . $nome_estado . " ($code)";
		}

		return $code;
	}

}
?>
