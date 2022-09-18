<?php
function total_views($link, $page_id = null)
{
  if($page_id === null)
  {
    // count total website views
    $query = "SELECT sum(total_views) as total_views FROM pages";
    $result = mysqli_query($link, $query);
    
    if(mysqli_num_rows($result) > 0)
    {
      while($row = $result->fetch_assoc())
      {
        if($row['total_views'] === null)
        {
          return 0;
        }
        else
        {
          return $row['total_views'];
        }
      }
    }
    else
    {
      return "No records found!";
    }
  }
  else
  {
    // count specific page views
    $query = "SELECT total_views FROM pages WHERE id='$page_id'";
    $result = mysqli_query($link, $query);
    
    if(mysqli_num_rows($result) > 0)
    {
      while($row = $result->fetch_assoc())
      {
        if($row['total_views'] === null)
        {
          return 0;
        }
        else
        {
          return $row['total_views'];
        }
      }
    }
    else
    {
      return "No records found!";
    }
  }
}



function is_unique_view($link, $visitor_ip, $page_id)
{
  $query = "SELECT * FROM page_views WHERE visitor_ip='$visitor_ip' AND page_id='$page_id'";
  $result = mysqli_query($link, $query);
  
  if(mysqli_num_rows($result) > 0)
  {
    return false;
  }
  else
  {
    return true;
  }
}



function add_view($link, $visitor_ip, $page_id)
{
  if(is_unique_view($link, $visitor_ip, $page_id) === true)
  {
    // insert unique visitor record for checking whether the visit is unique or not in future.
    $query = "INSERT INTO page_views (visitor_ip, page_id) VALUES ('$visitor_ip', '$page_id')";
    
    if(mysqli_query($link, $query))
    {
      // At this point unique visitor record is created successfully. Now update total_views of specific page.
      $query = "UPDATE pages SET total_views = total_views + 1 WHERE id='$page_id'";
      
      if(!mysqli_query($link, $query))
      {
        echo "Error updating record: " . mysqli_error($link);
      }
    }
    else
    {
      echo "Error inserting record: " . mysqli_error($link);
    }
  }
}
?>