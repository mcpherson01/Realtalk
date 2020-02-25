<?php

class AsgardAlerts_SocialNetwork {
  private $table_name = 'asgardalerts_pat_SocialNetwork';

  public function create($socialNetwork) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->query(
      $wpdb->prepare(
        "INSERT INTO $table(name, type, access_key) VALUES(%s, %s, %s)",
        array(
          $socialNetwork['name'],
          $socialNetwork['type'],
          $socialNetwork['access_key']
        )
      )
    );

    return $wpdb->insert_id;
  }

  public function getAll() {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $sql = "SELECT id, name, type, access_key FROM $table";
    return $wpdb->get_results($sql);
  }

  public function get($name) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    return $wpdb->get_results(
      $wpdb->prepare(
        "SELECT id, name, type, access_key FROM $table WHERE name = %s",
        array(
          $name
        )
      )
    );
  }

  public function update($socialNetwork) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->query(
      $wpdb->prepare(
        "UPDATE $table SET access_key = %s WHERE name = %s AND type = %s",
        array(
          $socialNetwork['access_key'],
          $socialNetwork['name'],
          $socialNetwork['type']
        )
      )
    );

    return $result;
  }
}

?>