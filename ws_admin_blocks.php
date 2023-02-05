<?php

function init_list_blocks_page()
{
    // Creating an instance
    $table = new WSListTable();

    echo '<style type="text/css">';
    echo '.wp-list-table .column-id { width: 40px; }';
    echo '.wp-list-table .column-count { width: 40px; }';
    echo '.wp-list-table .column-shortcode { width: 300px; }';
    echo '</style>';

    echo '<div class="wrap"><h2>Questions Blocks</h2>';
    $table->prepare_items();
    $table->display();
    echo '</div>';
}

class WSListTable extends WP_List_Table
{
    function get_columns()
    {
        $columns = array(
            'id'            => 'ID',
            'title'          => 'Name',
            'description'   => 'Description',
            'count' => 'Count',
            'shortcode' => 'Short code',
            'date_modified' => "Date"
        );
        return $columns;
    }

    function prepare_items()
    {
        $this->process_bulk_action();

        $data = WSAdminDB::instance()->fetchAllQuestions();

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // usort($data, array(&$this, 'sort_data'));

        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    function get_sortable_columns()
    {
        return array();
        // return array(
        //     'title' => array('title', true),
        //     'shortcode' => array('shortcode', true),
        // );
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'shortcode':
                $shortcode = htmlentities('[writestory_shortcode id="' . $item['id'] . '"]');
                return '<input style="width: 250px;" type="text" onClick="this.setSelectionRange(0, this.value.length)" readonly value="' . $shortcode . '" />';
            case 'count':
                return count(json_decode($item['questions']));
            case 'description':
                return htmlentities($item['description']);
            case 'title':
                return $this->column_title($item);
            case 'id':
            case 'date_modified':
            default:
                return $item[$column_name];
        }
    }

    function column_title($item)
    {
        $delete_nonce = wp_create_nonce($this->plugin_name . '-delete-survey');
        $title = sprintf('<strong><a href="?page=%s&action=%s&id=%d">%s</a></strong>', 'writestory_add_new', 'edit', absint($item['id']), $item['title']);

        $actions['edit'] = sprintf('<a href="?page=%s&action=%s&id=%d">' . 'Edit' . '</a>', 'writestory_add_new', 'edit', absint($item['id']));
        $actions['trash'] = sprintf('<a href="?page=%s&action=%s&id=%s&_wpnonce=%s">' . 'Delete' . '</a>', sanitize_text_field($_REQUEST['page']), 'delete', absint($item['id']), $delete_nonce);

        return $title . $this->row_actions($actions);
    }

    function process_bulk_action()
    {
        $current_action = $this->current_action();
        if ($current_action === 'delete') {
            WSAdminDB::instance()->deleteQuestion(absint(sanitize_text_field($_GET['id'])));

            $url = remove_query_arg(array('action', 'id', '_wpnonce'));
            wp_redirect($url);
        }
    }
}
