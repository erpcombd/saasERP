  <!--begin::Menu Start -->
  
  <?php
// Get the current page filename
$currentFile = basename($_SERVER['PHP_SELF']);

// Define an array of menu items and their respective URLs
$url = 'dashboard.php';
$url2 = 'productlist.php';
$url3 = 'addproduct.php';
$url4 = 'categorylist.php';
$url5 = 'brandlist.php';
$url6 = 'importproduct.php';
?>


<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li>
<a href="dashboard.php" class="<?php echo ($url == $currentFile) ? 'active' : ''; ?>"><img src="../assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/product.svg" alt="img"><span> Product</span> <span class="menu-arrow"></span> </a>
<ul>
<li><a href="productlist.php" class="<?php echo ($url2 == $currentFile) ? 'active' : ''; ?>">Product List</a></li>
<li><a href="addproduct.php" class="<?php echo ($url3 == $currentFile) ? 'active' : ''; ?>">Add Product</a></li>
<li><a href="categorylist.php" class="<?php echo ($url4 == $currentFile) ? 'active' : ''; ?>">Category List</a></li>
<li><a href="brandlist.php" class="<?php echo ($url5 == $currentFile) ? 'active' : ''; ?>">Brand List</a></li>
<li><a href="importproduct.php">Import Products</a></li>
<li><a href="barcode.php">Print Barcode</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/sales1.svg" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="saleslist.php">Sales List</a></li>
<li><a href="pos.php">POS</a></li>
<li><a href="add_sales.php">New Sales</a></li>
<li><a href="salesreturnlist.php">Sales Return List</a></li>
<li><a href="createsalesreturns.php">New Sales Return</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/purchase1.svg" alt="img"><span> Purchase</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="purchaselist.php">Purchase List</a></li>
<li><a href="addpurchase.php">Add Purchase</a></li>
<li><a href="importpurchase.php">Import Purchase</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/expense1.svg" alt="img"><span> Expense</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/expenselist.html">Expense List</a></li>
 <li><a href="https://dreamspos.dreamguystech.com/html/template/createexpense.html">Add Expense</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/expensecategory.html">Expense Category</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/quotation1.svg" alt="img"><span> Quotation</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/quotationList.html">Quotation List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/addquotation.html">Add Quotation</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/transfer1.svg" alt="img"><span> Transfer</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/transferlist.html">Transfer List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/addtransfer.html">Add Transfer </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/importtransfer.html">Import Transfer </a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/return1.svg" alt="img"><span> Return</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/salesreturnlist.html">Sales Return List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/createsalesreturn.html">Add Sales Return </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/purchasereturnlist.html">Purchase Return List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/createpurchasereturn.html">Add Purchase Return </a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/customerlist.html">Customer List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/addcustomer.html">Add Customer </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/supplierlist.html">Supplier List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/addsupplier.html">Add Supplier </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/userlist.html">User List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/adduser.html">Add User</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/storelist.html">Store List</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/addstore.html">Add Store</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/places.svg" alt="img"><span> Places</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/newcountry.html">New Country</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/countrieslist.html">Countries list</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/newstate.html">New State </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/statelist.html">State list</a></li>
</ul>
</li>
<li>
<a href="https://dreamspos.dreamguystech.com/html/template/components.html"><i data-feather="layers"></i><span> Components</span> </a>
</li>
<li>
<a href="https://dreamspos.dreamguystech.com/html/template/blankpage.html"><i data-feather="file"></i><span> Blank Page</span> </a>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i data-feather="alert-octagon"></i> <span> Error Pages </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/error-404.html">404 Error </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/error-500.html">500 Error </a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i data-feather="box"></i> <span>Elements </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/sweetalerts.html">Sweet Alerts</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/tooltip.html">Tooltip</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/popover.html">Popover</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/ribbon.html">Ribbon</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/clipboard.html">Clipboard</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/drag-drop.html">Drag & Drop</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/rangeslider.html">Range Slider</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/rating.html">Rating</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/toastr.html">Toastr</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/text-editor.html">Text Editor</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/counter.html">Counter</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/scrollbar.html">Scrollbar</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/spinner.html">Spinner</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/notification.html">Notification</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/lightbox.html">Lightbox</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/stickynote.html">Sticky Note</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/timeline.html">Timeline</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-wizard.html">Form Wizard</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i data-feather="bar-chart-2"></i> <span> Charts </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/chart-apex.html">Apex Charts</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/chart-js.html">Chart Js</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/chart-morris.html">Morris Charts</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/chart-flot.html">Flot Charts</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/chart-peity.html">Peity Charts</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i data-feather="award"></i><span> Icons </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-fontawesome.html">Fontawesome Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-feather.html">Feather Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-ionic.html">Ionic Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-material.html">Material Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-pe7.html">Pe7 Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-simpleline.html">Simpleline Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-themify.html">Themify Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-weather.html">Weather Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-typicon.html">Typicon Icons</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/icon-flag.html">Flag Icons</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i data-feather="columns"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-basic-inputs.html">Basic Inputs </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-input-groups.html">Input Groups </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-horizontal.html">Horizontal Form </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-vertical.html"> Vertical Form </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-mask.html">Form Mask </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-validation.html">Form Validation </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-select2.html">Form Select2 </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/form-fileupload.html">File Upload </a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i data-feather="layout"></i> <span> Table </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/tables-basic.html">Basic Tables </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/data-tables.html">Data Table </a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/product.svg" alt="img"><span> Application</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/chat.html">Chat</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/calendar.html">Calendar</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/email.html">Email</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/time.svg" alt="img"><span> Report</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/purchaseorderreport.html">Purchase order report</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/inventoryreport.html">Inventory Report</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/salesreport.html">Sales Report</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/invoicereport.html">Invoice Report</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/purchasereport.html">Purchase Report</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/supplierreport.html">Supplier Report</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/customerreport.html">Customer Report</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/users1.svg" alt="img"><span> Users</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/newuser.html">New User </a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/userlist.html">Users List</a></li>
</ul>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/settings.svg" alt="img"><span> Settings</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="https://dreamspos.dreamguystech.com/html/template/generalsettings.html">General Settings</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/emailsettings.html">Email Settings</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/paymentsettings.html">Payment Settings</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/currencysettings.html">Currency Settings</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/grouppermissions.html">Group Permissions</a></li>
<li><a href="https://dreamspos.dreamguystech.com/html/template/taxrates.html">Tax Rates</a></li>
</ul>
</li>
</ul>
</div>
</div>
</div>
		