  
<?php 
  if (!isset($_SESSION['CUSID'])){
      redirect("index.php");
     }

 
$query = "SELECT * FROM `tblsummary` s ,`tblcustomer` c 
    WHERE   s.`CUSTOMERID`=c.`CUSTOMERID` and ORDEREDNUM='".$_SESSION['ORDEREDNUM']."'";
    $mydb->setQuery($query);
    $cur = $mydb->loadSingleResult();

?>
 
<!-- 
<div class="modal-dialog" style="width:100%">
  <div class="modal-content">
  <div class="modal-header">
     <span id="printout"> -->
 
    <table>
      <tr>
        <td align="center"> 
        <img src="<?php echo web_root; ?>ecommerce-logo.jpg"  height="90px" style="-webkit-border-radius:5px; -moz-border-radius:5px;" alt="Image">
            </td>
        <td width="87%" align="center">
        <h3 >Tadeo Online E-Commerce</h3>
        <h4 >Brgy. Salong<br/>
        Kabankalan City<br/>
        </h4>
        </td>
      </tr>
    </table>
    
     
  <!--  <div class="modal-body">  -->
  <h4>Your order is on process. Please check your profile for notification of confirmation.</h4>
 
<hr/>
<!-- <h4><strong>Customer Information</strong></h4>
<div class="row"> 
    <div class="col-md-6 pull-left">

      <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
        Name:
      </div>
      <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
        <?php echo $cur->FNAME .' '.$cur->LNAME; ?>
      </div>
       <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
        Address:
      </div>
      <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
        <?php echo $cur->CUSHOMENUM . ' ' . $cur->STREETADD . ' ' .$cur->BRGYADD . ' ' . $cur->CITYADD . ' ' .$cur->PROVINCE . ' ' .$cur->COUNTRY; ?>
      </div>
    </div>

    <div class="col-md-6 pull-right">
    <div class="col-md-10 col-lg-12 col-sm-8">
      Order Number :<?php echo $cur->ORDEREDNUM; ?>
    </div>
    </div>
 </div> -->
 <h4><strong>Order Information</strong></h4>
    <table id="table" class="table">
      <thead>
        <tr>
          <th>PRODUCT</th>
          <th>PRICE</th>
          <th>QUANTITY</th>
          <th>TOTAL PRICE</th>
          <th></th> 
        </tr>
        </thead>
        <tbody>
 
        <?php
         
          $query = "SELECT * 
              FROM  `tblproduct` p, tblcategory ct,  `tblcustomer` c,  `tblorder` o,  `tblsummary` s
              WHERE p.`CATEGID` = ct.`CATEGID` 
              AND p.`PROID` = o.`PROID` 
              AND o.`ORDEREDNUM` = s.`ORDEREDNUM` 
              AND s.`CUSTOMERID` = c.`CUSTOMERID` 
              AND o.`ORDEREDNUM`=".$_SESSION['ORDEREDNUM'];
              $mydb->setQuery($query);
              $cur = $mydb->loadResultList(); 
            foreach ($cur as $result) {
              echo '<tr>';  
              echo '<td>'. $result->PROMODEL . ' <br/>'. $result->PRONAME .' '. $result->CATEGORIES. ' <br/>' .$result->PRODESC.'</td>';
              echo '<td> &#8369 '. number_format($result->PROPRICE,2).' </td>';
              echo '<td align="center" >'. $result->ORDEREDQTY.'</td>';
              ?>
               <td> &#8369 <output><?php echo  number_format($result->ORDEREDPRICE,2); ?></output></td> 
              <?php
              
              echo '</tr>';
         
        }
        ?> 
      </tbody>
    <tfoot >
    <?php 
         $query = "SELECT * FROM `tblsummary` s ,`tblcustomer` c 
        WHERE   s.`CUSTOMERID`=c.`CUSTOMERID` and ORDEREDNUM=".$_SESSION['ORDEREDNUM'];
    $mydb->setQuery($query);
    $cur = $mydb->loadSingleResult();

    if ($cur->PAYMENTMETHOD=="Cash on Delivery") {
      # code...
      $price = 25.00;
    }else{
      $price = 0.00;
    }


    $tot =   $cur->PAYMENT  - 25.00;
    ?>

   </tfoot>
       </table> <hr/>
    <div class="row">
        <div class="col-md-6 pull-left">
         <div>Ordered Date : <?php echo date_format(date_create($cur->ORDEREDDATE),"M/d/Y h:i:s"); ?></div> 
          <div>Payment Method : <?php echo $cur->PAYMENTMETHOD; ?></div>

        </div>
        <div class="col-md-6 pull-right">
          <p align="right">Total Price : &#8369 <?php echo number_format($tot,2);?></p>
          <p align="right">Delivery Fee : &#8369 <?php echo number_format($price,2); ?></p>
          <p align="right">Overall Price : &#8369 <?php echo number_format($cur->PAYMENT,2); ?></p>
        </div>
      </div>
     

<?php  unset($_SESSION['ORDEREDNUM']); ?>