<?php
require_once("functions.php");

class NewEvent
{
  private $id, $title, $description, $organizer, $type, $location, $start_date,
    $end_date, $time, $misc, $image, $contact, $added_on;

  function __construct($title = null)
  {
    if (!is_null($title)) {
      $conn = get_connection_handle();
      $query = $conn->query("select * from events where title = '$title'");
      if ($query && $query->num_rows > 0) {
        $rows = $query->fetch_object();
        $this->id = $rows->id;
        $this->title = $rows->title;
        $this->description = $rows->description;
        $this->location = $rows->location;
        $this->contact = $rows->contact;
        $this->organizer = $rows->organizer;
        $this->type = $rows->type;
        $this->start_date = $rows->start_date;
        $this->end_date = $rows->end_date;
        $this->added_on = $rows->added_on;
        $this->time = $rows->time;
        $this->misc = $rows->misc;
        $this->image = $this->get_image($title);
      }
    }

  }

  public function set_id($id)
  {
    $this->id = $id;
  }

  public function get_id()
  {
    return $this->id;
  }

  public function set_title($title)
  {
    $this->title = $title;
  }

  public function get_title()
  {
    return $this->title;
  }

  public function set_description($description)
  {
    $this->description = $description;
  }

  public function get_description()
  {
    return $this->description;
  }

  public function set_location($location)
  {
    $this->location = $location;
  }

  public function get_location()
  {
    return $this->location;
  }

  public function set_type($type)
  {
    $this->type = $type;
  }

  public function get_type()
  {
    return $this->type;
  }

  public function set_organizer($organizer)
  {
    $this->organizer = $organizer;
  }

  public function get_organizer()
  {
    return $this->organizer;
  }

  public function set_time($time)
  {
    $this->time = $time;
  }

  public function get_time()
  {
    return $this->time;
  }

  public function set_start_date($start_date)
  {
    $this->start_date = $start_date;
  }

  public function get_start_date()
  {
    return $this->start_date;
  }

  public function set_added_on($date)
  {
    $this->added_on = $date;
  }

  public function get_added_on()
  {
    return $this->added_on;
  }

  public function set_end_date($end_date)
  {
    $this->end_date= $end_date;
  }

  public function get_end_date()
  {
    return $this->end_date;
  }

  public function set_misc($misc)
  {
    $this->misc = $misc;
  }

  public function get_contact(){
    return $this->contact;
  }

  public function set_contact($contact){
    $this->contact = $contact;
  }
  public function get_misc()
  {
    return $this->misc;
  }

  public function set_image($image)
  {
    if ($_FILES[$image]) {
      //Determines file extenstion
      switch ($_FILES[$image]['type']) {
        case 'image/jpeg':
          $ext = 'jpg';
          break;
        case 'image/gif':
          $ext = 'gif';
          break;
        case 'image/png':
          $ext = 'png';
          break;
        default:
          $ext = '';
          break;
      }
    //Checks format and uploads image
      if ($ext) {
        $img_dir = "images/events/";
        $image = md5($this->title) . "." . $ext;
        if (move_uploaded_file($_FILES[$image]['tmp_name'], $img_dir . $image)) {
          return true;
        }
      } else {
        echo "Image not a supported format";
      }
    } else {
      echo "No image selected";
    }
    return false;
  }

  public function get_image($title)
  {
    $y = new DateTime($this->added_on);
    $yr = $y->format("Y");
    $img = implode("-", explode(" ", strtolower($title)));
    $filehandle = "images/events/".$yr."/".$img;
      //Is the image a .png file...
    if (file_exists($filehandle . ".png")) {
      $image = $filehandle . ".png";
    } elseif (file_exists($filehandle . ".jpg")) {
      $image = $filehandle . ".jpg";

    } elseif (file_exists($filehandle . ".gif")) {

      $image = $filehandle . ".gif";

    } else {//Fallback to default if no image exists for event
      $image = "images/events/default.jpg";
    }
    $this->image = $image;
    return $this->image;
  }

  public function get_events_by_date($date, $end_date = null)
  {
    if (!is_null($date) && !empty($date)) {
      $conn = get_connection_handle();
      if (is_null($end_date)) {
        $query = $conn->query("select * from events where start_date = '$date'");
      } else {
        $query = $conn->query("select * from events where start_date between
        '$date' and '$end_date'");
      }

      if ($query && $query->num_rows > 0) {
        return $query;
      }
    }
  }

  public function get_events_by_organizer($organizer)
  {
    if (!is_null($organizer) && !empty($organizer)) {
      $conn = get_connection_handle();
      $query = $conn->query("select * from events where organizer =
      '$organizer'");
      if ($query && $query->num_rows > 0) {
        return $query;
      }
    }
  }

  public function get_events_by_location($location)
  {
    if (!is_null($location) && !empty($location)) {
      $conn = get_connection_handle();
      $query = $conn->query("select * from events where location =
      '$location'");
      if ($query && $query->num_rows > 0) {
        return $query;
      }
    }
  }

  public function get_events_by_type($type)
  {
    if (!is_null($type) && !empty($type)) {
      $conn = get_connection_handle();
      $query = $conn->query("select * from events where type =
      '$type'");
      if ($query && $query->num_rows > 0) {
        return $query;
      }
    }
  }

  public function get_events($limit)
  {
    if (!is_null($limit) && !empty($limit) && is_numeric($limit)) {
      $conn = get_connection_handle();
      $query = $conn->query("select * from events limit $limit");
      if ($query && $query->num_rows > 0) {
        return $query;
      }
    }
  }

  public function get_event_by_id($id)
  {
    if (!is_null($id) && !empty($id)) {
      $conn = get_connection_handle();
      $query = $conn->query("select * from events where id = $id");
      if ($query && $query->num_rows > 0) {
        $row = $query->fetch_object();
        return $row;
      }
    }
  }

  function update()
  {
    $id = $this->get_id();
    $conn = get_connection_handle();
    $stmt = $conn->prepare("update events set title = ?, description = ?,
    organizer = ?, type = ?, location = ?, start_date = ?, end_date = ?,
    time = ?, misc = ? where id = ?");

    $stmt->bind_param(
      'sssssssssi',
      $this->title,
      $this->description,
      $this->organizer,
      $this->type,
      $this->location,
      $this->start_date,
      $this->end_date,
      $this->time,
      $this->misc,
      $id
    );

    $stmt->execute();
    if ($conn->affected_rows == 1) {
      return true;
    }
    return false;
  }

  function add()
  {
    $conn = get_connection_handle();
    $stmt = $conn->prepare("insert into events(title, description, contact, 
    organizer, type, location, start_date, end_date, time, added_on, misc)
    values(?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param(
      'sssssssssss',
      $this->title,
      $this->description,
      $this->contact,
      $this->organizer,
      $this->type,
      $this->location,
      $this->start_date,
      $this->end_date,
      $this->time,
      $this->added_on,
      $this->misc
    );

    $stmt->execute();
    if ($conn->affected_rows == 1) {
        return true;
    }
    return false;
  }
}
?>
