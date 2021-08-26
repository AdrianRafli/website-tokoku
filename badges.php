<?php 
    $uid = $_SESSION['id'];

    // badges cart
  $caricart = mysqli_query($conn,"SELECT * FROM cart WHERE userid='$uid' AND status='Cart'");
  $fetc = mysqli_fetch_array($caricart);
  $orderidd = $fetc['orderid'];
  $itungtrans = mysqli_query($conn,"SELECT count(detailid) AS jumlahtrans FROM detailorder WHERE orderid='$orderidd'");
  $itungtrans2 = mysqli_fetch_assoc($itungtrans);
  $itungtrans3 = $itungtrans2['jumlahtrans'];

  // badgest detail order
  $cariorder = mysqli_query($conn,"SELECT * FROM cart WHERE userid='$uid' AND status='Payment'");
  $fetch = mysqli_fetch_array($cariorder);
  $orderid = $fetch['orderid'];
  $itungorder = mysqli_query($conn,"SELECT count(detailid) AS jumlahorder FROM detailorder WHERE orderid='$orderid'");
  $itungtorder2 = mysqli_fetch_assoc($itungorder);
  $itungorder3 = $itungtorder2['jumlahorder'];
?>