<?php

function init_list_blocks_page()
{
    // Creating an instance
    $table = new WSListTable();

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
            // 'id'            => 'ID',
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
                return '[writestory_shortcode id="' . $item['id'] . '"]';
            case 'count':
                return count(json_decode($item['questions']));
            case 'id':
            case 'title':
            case 'description':
            case 'date_modified':
            default:
                return $item[$column_name];
        }
    }
}
