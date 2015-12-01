<?php
Class WelcomeModel extends CI_Model
{

  function getTableRows()
  {
    $query = $this->db->query("select * from ford_db.results;");
    return $query->result();
  }

  function getDistinctFileType()
  {
	  $query = $this->db->query("SELECT count(file_type) as count, file_type FROM ford_db.results group by file_type;");
	  return $query->result();
  }

  function getDistinctPktSize()
  {
	  $query = $this->db->query("SELECT count(pkt_size) as count, pkt_size FROM ford_db.results group by pkt_size ORDER BY cast(pkt_size as unsigned) ASC;");
	  return $query->result();
  }

  function getDistinctEncryptionUsed()
  {
	  $query = $this->db->query("SELECT count(encryption_used) as count, encryption_used FROM ford_db.results group by encryption_used;");
	  return $query->result();
  }

  function getDistinctFileSize()
  {
	  $query = $this->db->query("SELECT count(file_size) count, file_size FROM ford_db.results group by file_size order by cast(file_size as unsigned) asc;");
	  return $query->result();
  }

  function getDistinctProtocol()
  {
	  $query = $this->db->query("SELECT count(protocol) as count, protocol FROM ford_db.results group by protocol;");
	  return $query->result();
  }

  function getAverageTotalTime()
  {
	  $query = $this->db->query("SELECT protocol, avg(total_time) as total_time from ford_db.results group by protocol;");
	  return $query->result();
  }
}
?>
