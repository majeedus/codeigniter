<?php
Class SearchModel extends CI_Model
{

  //TODO MAKE THIS FAR NICER!
  function query($post, $protocol = null)
  {
    $close = ";";
    $queryBuilder = "SELECT protocol, file_type, " . $post['time'] . " FROM ford_db.results WHERE ";

    if(!empty($protocol)){
      $queryBuilder .= " (protocol='" . $protocol . "') AND";
    } else if(!empty($post['protocol'])){
      $protocols = count($post['protocol']);
      $i = 0;
      foreach($post['protocol'] as $proto){
        if($i == 0 && $protocols == 1){
          $queryBuilder .=  "(protocol='". $proto . "') AND";
        } else {
          if($i == 0){
            $queryBuilder .= "(protocol='" . $proto . "' OR ";
          } else if($i == ($protocols - 1)){
            //last one
            $queryBuilder .=  "protocol='". $proto . "') AND ";
          } else {
            $queryBuilder .=  "protocol='". $proto . "' OR ";
          }
        }
        $i++;
      }
    }

    if(!empty($post['file_type'])){
      $file_types = count($post['file_type']);
      $i = 0;
      foreach($post['file_type'] as $type){
        if($i == 0 && $file_types == 1){
          $queryBuilder .=  " (file_type='". $type . "') AND";
        } else {
          if($i == 0){
            $queryBuilder .= " (file_type='" . $type . "' OR ";
          } else if($i == ($file_types - 1)){
            //last one
            $queryBuilder .=  "file_type='". $type . "') AND";
          } else {
            $queryBuilder .=  "file_type='". $type . "' OR ";
          }
        }
        $i++;
      }
    }

    $queryBuilder .= " encryption_used='" . $post['encrypted'] ."' AND ";
    //this should be last
    if($post['min_package'] > $post['max_package']){
      //WHERE id BETWEEN 10 AND 15
      $queryBuilder .= " pkt_size BETWEEN " . $post['max_package'] . " AND " . $post['min_package'];
    } else { //it's normal and the user doesn't hate us
      $queryBuilder .= " pkt_size BETWEEN " . $post['min_package'] . " AND " . $post['max_package'];
    }
    $query = $this->db->query($queryBuilder . $close);
    return $query->result();
  }
}
?>
