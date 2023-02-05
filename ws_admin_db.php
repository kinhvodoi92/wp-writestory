<?php


class WSAdminDB
{

    private $writestory_db_version = '1.0';
    private $table_suffix = 'writestory_blocks';

    private static $instance;
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new WSAdminDB();
        }
        return self::$instance;
    }

    private function __construct()
    {
        // $this->writestory_update_db_check();
    }

    private function writestory_install_db()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_suffix;
        echo $table_name;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE `" . $table_name . "` (
            `id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `title` text NOT NULL,
            `description` text,
            `questions` json,
            `shortcode` text,
            `status` integer,
            `date_created` datetime DEFAULT '0000-00-00 00:00:00',
            `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY (`id`)
            )$charset_collate;";

        $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
    WHERE table_schema = '" . DB_NAME . "' AND table_name = '" . $table_name . "' ";
        $results = $wpdb->get_results($sql_schema);

        if (empty($results)) {
            $wpdb->query($sql);
        } else {
            dbDelta($sql);
        }

        add_option('writestory_db_version', $this->writestory_db_version);
    }

    public function writestory_update_db_check()
    {
        if (get_site_option('writestory_db_version') != $this->writestory_db_version) {
            $this->writestory_install_db();
        }
    }

    public function addQuestion($title, $description, $questions)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_suffix;
        $wpdb->insert($table_name, array(
            'title' => sanitize_text_field($title),
            'description' => sanitize_text_field($description),
            'status' => 1,
            'questions' => json_encode($questions),
            'date_created' => current_time('mysql'),
            'date_modified' => current_time('mysql'),
        ));
    }

    public function fetchAllQuestions()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_suffix;
        return $wpdb->get_results(
            "SELECT * from {$table_name}",
            ARRAY_A
        );
    }

    public function fetchQuestion($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_suffix;
        $list = $wpdb->get_row("SELECT * FROM {$table_name} WHERE `id` = {$id}");
        return $list;
    }
}
