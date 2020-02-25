<?php

class AsgardAlerts_Profile {
  private $table_name = 'asgardalerts_fb_Profile';

  public function create($profile) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->query(
      $wpdb->prepare(
        "INSERT INTO $table(name, code, builderData) VALUES(%s, '{$profile['code']}', '{$profile['builderData']}')",
        array(
          $profile['name']
        )
      )
    );

    return $wpdb->insert_id;
  }

  public function getAll() {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $sql = "SELECT id, name, code, builderData, time, desktop, tablet, mobile, active FROM $table ORDER BY id DESC";
    return $wpdb->get_results($sql);
  }

  public function get($profile_id) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    return $wpdb->get_row(
      $wpdb->prepare(
        "SELECT id, name, code, builderData FROM $table WHERE id = %d",
        array(
          $profile_id
        )
      )
    );
  }

  public function update($profile) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->query(
      $wpdb->prepare(
        "UPDATE $table SET name = %s, code = '{$profile['code']}', builderData = '{$profile['builderData']}' WHERE id = %d",
        array(
          $profile['name'],
          $profile['id']
        )
      )
    );

    return $result;
  }

  public function updateDesktop($profile) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->query(
      $wpdb->prepare(
        "UPDATE $table SET desktop = %s WHERE id = %d",
        array(
          $profile['desktop'],
          $profile['id']
        )
      )
    );

    return $result;
  }

  public function updateTablet($profile) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->query(
      $wpdb->prepare(
        "UPDATE $table SET tablet = %s WHERE id = %d",
        array(
          $profile['tablet'],
          $profile['id']
        )
      )
    );

    return $result;
  }

  public function updateMobile($profile) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->query(
      $wpdb->prepare(
        "UPDATE $table SET mobile = %s WHERE id = %d",
        array(
          $profile['mobile'],
          $profile['id']
        )
      )
    );

    return $result;
  }

  public function delete($profile, $formats) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $result = $wpdb->delete($table, $profile, $formats);

    return $result;
  }

  public function activate($profile_id) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    // deactivate all
    $deactivate_row_count = $wpdb->update($table, array('active' => '0'), array('active' => '1'), array('%d'), array('%d'));

    if ($deactivate_row_count === false) return false;

    // activate with argument id
    $activate_row_count = $wpdb->update($table, array('active' => '1'), array('id' => $profile_id), array('%d'), array('%d'));

    return $activate_row_count;
  }

  public function deactivate($profile_id) {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    // deactivate with argument id
    $deactivate_row_count = $wpdb->update($table, array('active' => '0'), array('id' => $profile_id), array('%d'), array('%d'));

    return $deactivate_row_count;
  }

  public function getActive() {
    global $wpdb;
    $table = $wpdb->prefix . $this->table_name;

    $sql = "SELECT name, code, builderData, desktop, tablet, mobile, active FROM $table WHERE active = 1";
    return $wpdb->get_row($sql);
  }
}

?>