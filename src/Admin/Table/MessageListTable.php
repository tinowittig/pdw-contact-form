<?php

namespace Pdw\Pdw_Contact_Form\Admin\Table;

use DateTime;
use Pdw\Pdw_Contact_Form\Plugin;
use WP_List_Table;

class MessageListTable extends WP_List_Table {
	private int $itemsPerPage = 20;

	public function __construct() {
		$args = [
			'plural'   => __( 'Nachrichten', Plugin::getTranslationDomain() ),
			'singular' => __( 'Nachricht', Plugin::getTranslationDomain() ),
		];
		add_thickbox();

		parent::__construct( $args );
	}

	public function prepare_items(): void {

		$this->_column_headers = [
			$this->get_columns(),
		];

		$this->process_bulk_action();

		$page = $this->get_pagenum();

		$offset = ( $page - 1 ) * $this->itemsPerPage;

		$this->set_pagination_args(
			array(
				'total_items' => $this->get_total_items(),
				'per_page'    => $this->itemsPerPage,
			)
		);

		$this->items = $this->get_table_data( array(
			'offset'   => $offset,
			'per_page' => $this->itemsPerPage
		) );
	}

	public function get_columns(): array {
		return [
			'cb'        => '<input type="checkbox" />',  // display checkbox
			'name'      => __( 'Name', Plugin::getTranslationDomain() ),
			'email'     => __( 'E-Mail', Plugin::getTranslationDomain() ),
			'subject'   => __( 'Betreff', Plugin::getTranslationDomain() ),
			'createdAt' => __( 'Erstellt am', Plugin::getTranslationDomain() ),
		];
	}

	public function process_bulk_action(): void {
		global $wpdb;
		if ( ! empty( $_POST['_wpnonce'] ) ) {
			$nonce  = htmlspecialchars( $_POST['_wpnonce'] );
			$action = 'bulk-' . $this->_args['plural'];
			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				wp_die( __( 'Security check failed!', 'theme-name' ) );
			}
			if ( ( isset( $_POST['action'] ) && $_POST['action'] === 'delete_all' )
			     || ( isset( $_POST['action2'] ) && $_POST['action2'] === 'delete_all' )
			) {
				$ids = $_POST['messages'];
				foreach ( $ids as $id ) {
					$wpdb->delete( $wpdb->prefix . "pdw_contact_form_message", array( "id" => $id ), "%d" );
				}
			}
		}
	}

	private function get_total_items(): int {
		global $wpdb;

		return (int) $wpdb->get_var( "SELECT COUNT(`id`) FROM " . $wpdb->prefix . "pdw_contact_form_message" );
	}

	private function get_table_data( $args = array() ): array|object|null {
		global $wpdb;

		return $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "pdw_contact_form_message ORDER BY id DESC LIMIT {$args['offset']}, {$args['per_page']}" );
	}

	protected function column_default( $item, $column_name ) {
		if ( $column_name === 'createdAt' ) {
			return ( new DateTime( $item->createdAt ) )->format( 'd.m.Y H:i' );
		}

		return $item->{$column_name};
	}

	protected function column_cb( $item ): string {
		return '<input id="cb-select-' . $item->id . '" type="checkbox" name="messages[]" value="' . $item->id . '" />';
	}

	protected function column_name( $item ): string {
		$output = '';

		// Title.
		$output .= '<strong>' . $item->name . '</strong>';

		$output .= '<div ><span class="details"><a class="thickbox" href="TB_inline?inlineId=pdw-scf-message-' . $item->id . '">' . esc_html__( 'Details', Plugin::getTranslationDomain() ) . '</a></span></div>';
		$output .= '<div style="display:none;" id="pdw-scf-message-' . $item->id . '"><div>
<p>
	<strong>Name:</strong> <br/>' . $item->name . '</p>
	<strong>E-Mail:</strong> <br>' . $item->email . '<br><br>
	<strong>Betreff:</strong> <br>' . $item->subject . '<br><br>
	<strong>Nachricht:</strong> <br>' . $item->message . '<br><br>
	</div>
</div>';

		return $output;
	}

	protected function get_bulk_actions() {
		return array( 'delete_all' => __( 'löschen', Plugin::getTranslationDomain() ) );
	}
}