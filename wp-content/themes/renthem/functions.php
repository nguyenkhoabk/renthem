<?php


	


function register_my_menus()
{
	register_nav_menus(array('my-menu' => 'Menu-1'));
}

add_action('init', 'register_my_menus');

function theme_wp_title($title, $sep)
{
	global $paged, $page;

	if (is_feed()) return $title;

	$title .= get_bloginfo('name');

	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page())) $title = "$title $sep $site_description";

	if ($paged >= 2 || $page >= 2) $title = "$title $sep " . sprintf( __( 'Page %s', 'renthem'), max($paged, $page));

	return $title;
}

add_filter('wp_title', 'theme_wp_title', 10, 2);

function ShowPageTitle()
{
	$p = get_post();
	echo '<div class="title"><h1>'.$p->post_title.'</h1></div>';
}

function ShowPagePosts()
{
	while (have_posts()) {
		the_post();
		the_content();
	}
}

function ShowPageContent($pn)
{
   $query = new WP_Query('pagename='.$pn);

   if ($query->have_posts()) {
      while ($query->have_posts()) {
         $query->the_post();
         the_content();
      }
   }

   wp_reset_postdata();
}

function ShowPageShort($id)
{
	$p = get_page($id);
	echo '<div class="title">'.$p->post_title.'</div>';
	$tx = strip_shortcodes( wp_trim_words($p->post_content, 12, '') );
	echo '<div class="txt">'.$tx.'...';
	$ad = get_permalink($id);
	echo '<a href="'.$ad.'"><span>läs mer</span></a></div>';
}

function ShowPageLink($id)
{
	if (get_the_id() == 1) {
		$id -= 30;
		if ($id > 21) $id += 2;
	}
	$p = get_page($id);
	$a = get_permalink($id);
	echo '<div class="link"><a href="'.$a.'">'.$p->post_title.'</a></div>';
}

function ShowLastPost($i)
{
	$n = 0;
	$rp = get_posts('numberposts=2&category_name=news');
	foreach ($rp as $p) {
		if (++$n == $i) {	
			$ad = get_permalink($p->ID);
			echo '<a href="'.$ad.'">';
			echo '<div class="title">'.$p->post_title.'</div>';

            $tx = strip_shortcodes( wp_trim_words($p->post_content, 33, '') );
            echo '<div class="txt">'.$tx.'...';
            echo '<span class="merinfo"> mer info</span></div></a>';
		}
	}
	wp_reset_postdata();
}

function ShowPageContent_ID($id)
{
   $query = new WP_Query('page_id='.$id);

   if ($query->have_posts()) {
      while ($query->have_posts()) {
         $query->the_post();
         the_content();
      }
   }

   wp_reset_postdata();
}

register_sidebar(array(
	'name' => 'sidebar',
	'id' => 'sidebar',
	'description' => 'sidebar',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
));



register_sidebar(array(
	'name' => 'homeinfo',
	'id' => 'homeinfo',
	'description' => 'homeinfo',
	'before_widget' => '<div class="homeinfo"><a class="fb" href="https://www.facebook.com/renthem"></a>',
	'after_widget' => '</div>',
	'before_title' => '',
	'after_title' => '',
));

register_sidebar(array(
	'name' => 'slider',
	'id' => 'slider',
	'description' => 'slider',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
));
register_sidebar(array(
	'name' => 'menures',
	'id' => 'menures',
	'description' => 'menures',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
));

register_sidebar(array(
	'name' => 'menuf',
	'id' => 'menuf',
	'description' => 'menuf',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
));

register_sidebar(array(
	'name' => 'news',
	'id' => 'news',
	'description' => 'news',
	'before_widget' => '<div class="news">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

register_sidebar(array(
	'name' => 'bignews',
	'id' => 'bignews',
	'description' => 'bignews',
	'before_widget' => '<div class="cont">',
	'after_widget' => '</div>',
	'before_title' => '<h1>',
	'after_title' => '</h1>',
));
register_sidebar(array(
	'name' => 'img',
	'id' => 'img',
	'description' => 'img',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

register_sidebar(array(
	'name' => 'kontakt',
	'id' => 'kontakt',
	'description' => 'kontakt',
	'before_widget' => '<div id="kontakt">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));


register_sidebar(array(
	'name' => 'ckontakt',
	'id' => 'ckontakt',
	'description' => 'ckontakt',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
));



register_sidebar(array(	'name' => 'custom',	'id' => 'custom',	'description' => 'kontakt',	'before_widget' => '<div id="kontakt">',	'after_widget' => '</div>',	'before_title' => '<h3>',	'after_title' => '</h3>',));



/************************************Booking Calender Widegets***************************************/
// include('BookingCalender.php');
class CalenderNewWidgetRent extends WP_Widget {

	function CalenderNewWidgetRent() {
		// Instantiate the parent object
		$widgetOptions = array( 'description' => __('Use this widget to add booking calendar to the sidebar'));
		parent::__construct(false, __('Booking Calender Rent Hem'), $widgetOptions);
	}

	function widget( $args, $instance ) {
		// Widget output
		BookingCalender();
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		update_option('BookingCalenderRentHem', $_POST['BookingCalenderRentHem']);
		
	}

	function form( $instance ) {
		// Output admin widget options form
		?>
		Title : <input type="text" name="BookingCalenderRentHem" value="<?php echo get_option('BookingCalenderRentHem'); ?>"  />
        <?php
	}
}

function CalenderNewWidgetRent_register_widgets() 
{
	register_widget( 'CalenderNewWidgetRent' );
}

add_action( 'widgets_init', 'CalenderNewWidgetRent_register_widgets' );

/*********************************************************************************FOR CALENDER**********************************/
global $custom_table_example_db_version;
$custom_table_example_db_version = '1.1'; // version changed from 1.0 to 1.1
// include('BookingOnlyCalender.php');

function custom_table_example_install()
{
    global $wpdb;
    global $custom_table_example_db_version;
	$table_name = $wpdb->prefix."bookings";
	$sql = "CREATE TABLE IF NOT EXISTS `".$table_name."`(
				  `Id` bigint(20)NOT NULL auto_increment,
				  `standing` varchar(50) NOT NULL,
				  `size` varchar(50) NOT NULL,
				  `often` varchar(100) NOT NULL,
				  `amount` varchar(50) NOT NULL,
				  `Display_date` date  NOT NULL,
				  `timeval` varchar(50) NOT NULL,
				  `name` varchar(200) NOT NULL,
				  `address` text NOT NULL,
				  `postno` varchar(50) NOT NULL,
				  `city` varchar(200) NOT NULL,
				  `kvm` varchar(50) NOT NULL,
				  `mobileno` varchar(20) NOT NULL,
				  `email` varchar(200) NOT NULL,
				  `custommessag` varchar(200) NOT NULL,
				  `orderTime` date NOT NULL,
				  PRIMARY KEY (`Id`)
		);";
    // we are calling dbDelta which cant migrate database
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    // save current database version for later use(on upgrade)
    add_option('custom_table_example_db_version', $custom_table_example_db_version);
    $installed_ver = get_option('custom_table_example_db_version');
    if($installed_ver != $custom_table_example_db_version)
	{
		$sql = "CREATE TABLE IF NOT EXISTS `".$table_name."`(
					  `Id` bigint(20)NOT NULL auto_increment,
					  `standing` varchar(50)NOT NULL,
					  `size` varchar(50)NOT NULL,
					  `often` varchar(100) NOT NULL,
					  `amount` varchar(50)NOT NULL,
					  `Display_date` date NOT NULL,
					  `timeval` varchar(50)NOT NULL,
					  `name` varchar(200)NOT NULL,
					  `address` text NOT NULL,
					  `postno` varchar(50)NOT NULL,
					  `city` varchar(200)NOT NULL,
					  `kvm` varchar(50)NOT NULL,
					  `mobileno` varchar(20)NOT NULL,
					  `email` varchar(200)NOT NULL,
					  PRIMARY KEY (`Id`)
		);";
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        // notice that we are updating option, rather than adding it
        update_option('custom_table_example_db_version', $custom_table_example_db_version);
    }
}
register_activation_hook(__FILE__, 'custom_table_example_install');
/**
 * register_activation_hook implementation
 *
 * [OPTIONAL]
 * additional implementation of register_activation_hook
 * to insert some dummy data
 */
/*
function custom_table_example_install_data()
{
    global $wpdb;
    $table_name = $wpdb->prefix.'cte'; // do not forget about tables prefix
    $wpdb->insert($table_name, array(
        'name' => 'Alex',
        'email' => 'alex@example.com',
        'age' => 25
   ));
    $wpdb->insert($table_name, array(
        'name' => 'Maria',
        'email' => 'maria@example.com',
        'age' => 22
   ));
}*/
//register_activation_hook(__FILE__, 'custom_table_example_install_data');
/**
 * Trick to update plugin database, see docs
 */

function custom_table_example_update_db_check()
{
    global $custom_table_example_db_version;
    if(get_site_option('custom_table_example_db_version')!= $custom_table_example_db_version)
	{
        custom_table_example_install();
    }
}
add_action('plugins_loaded', 'custom_table_example_update_db_check');
/**
 * PART 2. Defining Custom Table List
 * ============================================================================
 *
 * In this part you are going to define custom table list class,
 * that will display your database records in nice looking table
 *
 * http://codex.wordpress.org/Class_Reference/WP_List_Table
 * http://wordpress.org/extend/plugins/custom-list-table-example/
 */
if(!class_exists('WP_List_Table'))
{
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}
/**
 * Custom_Table_Example_List_Table class that will display our custom table
 * records in nice table
 */
class Custom_Table_Example_List_Table extends WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    
	function __construct()
    {
        global $status, $page;
        parent::__construct(array(
            'singular' => 'booking',
            'plural' => 'bookings',
       ));
    }
    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row(key, value array)
     * @param $column_name - string(key)
     * @return HTML
     */
    
	function column_default($item, $column_name)
    {
        return $item[$column_name];
    }
    
	function column_name($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=persons_form&Id=%s">%s</a>', $item['Id'], __('Edit', 'custom_table_example')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['Id'], __('Delete', 'custom_table_example')),
       );
        return sprintf('%s %s',
            $item['name'],
            $this->row_actions($actions)
       );
    }
    
	function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['Id']
       );
    }
    
	function get_columns()
    {
       $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => __('Name', 'custom_table_example'),
            'email' => __('E-Mail', 'custom_table_example'),
            'standing'=> __('Standing', 'custom_table_example'),
            'size'=> __('Size', 'custom_table_example'),
			'often'=> __('Often', 'custom_table_example'),
			'amount'=> __('Amount', 'custom_table_example'),
			'Display_date'=> __('Booking Date', 'custom_table_example'),
			'orderTime'=> __('Order Date', 'custom_table_example'),
			'timeval'=> __('Time', 'custom_table_example'),
			'custommessag'=> __('Message', 'custom_table_example'),
			'StaffName'=> __('Staff Name', 'custom_table_example'),
			'SendMailStatus'=> __('Schedule Mail', 'custom_table_example')
       );
        return $columns;
    }
    
	function get_sortable_columns()
    {
        $sortable_columns = array(
            'name' => array('name', true),
            'amount' => array('amount', true),
            'Display_date' => array('Display_date', true),
       );
        return $sortable_columns;
    }
    
	function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
       );
        return $actions;
    }
    
	function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix.'bookings'; // do not forget about tables prefix
        if('delete' === $this->current_action())
		{
            $ids = isset($_REQUEST['id'])? $_REQUEST['id'] : array();
            if(is_array($ids))$ids = implode(',', $ids);
            if(!empty($ids))
			{
                $wpdb->query("DELETE FROM `".$table_name."` WHERE `Id` IN(".$ids.")");
            }
        }
    }
    
	function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix.'bookings'; // do not forget about tables prefix
        $per_page = 20; // constant, how much records will be shown per page
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);
        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();
        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(`id`) FROM `".$table_name."`");
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged'])? max(0, intval($_REQUEST['paged'])- 1): 0;
        $orderby =(isset($_REQUEST['orderby'])&& in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns())))? $_REQUEST['orderby'] : 'name';
        $order =(isset($_REQUEST['order'])&& in_array($_REQUEST['order'], array('asc', 'desc')))? $_REQUEST['order'] : 'asc';
        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
		$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM `".$table_name."` INNER JOIN `".$wpdb->prefix."stafftable` ON `".$table_name."`.`StaffId`=`".$wpdb->prefix."stafftable`.`id` ORDER BY ".$orderby." ".$order." LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page)// calculate pages count
       ));
    }
}



function rm_admin_js_css($hook)
{
    wp_register_style('admin-css', get_template_directory_uri(). '/css/admin.css');
    wp_register_script('admin-js',(get_template_directory_uri().  '/js/admin.js'), array('jquery'), false, true);
    wp_register_script('admin2-js',(get_template_directory_uri().  '/js/admin2.js'), array('jquery'), false, true);
    
    if($hook == 'hour_page_Hour_list' || $hook == 'hour_page_Hour_list3')
	{
        wp_enqueue_style('admin-css');
        wp_enqueue_script('admin-js');
    }
    elseif($hook == 'toplevel_page_Hour')
	{
        wp_register_script('jquery-numeric',(get_template_directory_uri().  '/js/jquery.numeric.js'), array('jquery'), false, true);
        wp_enqueue_style('admin-css');
        wp_enqueue_script('jquery-numeric');
        wp_enqueue_script('admin2-js');
    }
    elseif($hook == 'booking_page_persons_form')
	{
        wp_register_script('edit-booking',(get_template_directory_uri(). '/js/admin_booking.js'), array('jquery'), false, true);
        wp_enqueue_script('edit-booking');
    }
}
add_action('admin_enqueue_scripts', 'rm_admin_js_css');

function rm_frontend_js_css()
{
    wp_register_script('main',(get_template_directory_uri(). '/js/main.js'), array('jquery'), false, true);
    wp_enqueue_script('main');
}
add_action('wp_enqueue_scripts', 'rm_frontend_js_css');
add_action('wp_ajax_rm_save_cat', 'rm_save_cat');

function rm_save_cat()
{
    check_ajax_referer('rm_save_cat', 'rm_save_cat_nonce');
    global $wpdb;
    if(empty($_POST["cat_name"]))
    {
        exit;
    }
	$parent = $_POST['cat1'] ? 52 :($_POST['cat2'] ? 53 :($_POST['cat3'] ? 48 : ''));
    if($_POST["cat_val"] == '')
    {
		$_POST["cat_val"] = $_POST["cat_name"];
    }
	$conds = $_POST['conds'] ? maybe_serialize(explode(',', $_POST['conds'])): null;
    $wpdb->insert(
        $wpdb->prefix.'ea_category',
        array(
            'id' => '',
            'name' => $_POST["cat_name"],
            'description' => $_POST["cat_val"],
            'parent' => $parent,
            'conditions' => $conds,
            'bind_to' => $_POST['bind_to'],
            'entry_time' => current_time('mysql', 1),
       )
   );
    $cats1 = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."ea_category` WHERE `parent` = 52", ARRAY_A);
    $cats2 = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."ea_category` WHERE `parent` = 53", ARRAY_A);
    $new_stadning_options = '';
    $new_ofta_options = '';
    if(is_array($cats1))foreach($cats1 as $cat)
    {
		$new_stadning_options .= "<option value='{$cat['id']}'>{$cat['name']}</option>";
	}
    if(is_array($cats2))foreach($cats2 as $cat)
    {
		$new_ofta_options .= "<option value='{$cat['id']}'>{$cat['name']}</option>";
	}
    exit(
        json_encode(array(
            'id' => $wpdb->insert_id,
            'new_stadning_options' => $new_stadning_options,
            'new_ofta_options' => $new_ofta_options,
            'cats_table' => rm_generate_cats_table(),
            'items_table' => rm_generate_items_table(),
       ))
   );
}
add_action('wp_ajax_rm_delete_cat', 'rm_delete_cat');

function rm_delete_cat()
{
    check_ajax_referer('rm_delete_cat', 'rm_delete_cat_nonce');
    global $wpdb;
    $id =(int)$_POST["id"];
    if(empty($_POST["id"]))
    {
		exit;
    }
    $wpdb->delete($wpdb->prefix.'ea_category', array('id' => $id));
    $cats1 = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."ea_category` WHERE `parent` = 52", ARRAY_A);
    $cats2 = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."ea_category` WHERE `parent` = 53", ARRAY_A);
    $new_stadning_options = '';
    $new_ofta_options = '';
    if(is_array($cats1))foreach($cats1 as $cat)
    {
		$new_stadning_options .= "<option value='{$cat['id']}'>{$cat['name']}</option>";
	}
    if(is_array($cats2))foreach($cats2 as $cat)
    {
		$new_ofta_options .= "<option value='{$cat['id']}'>{$cat['name']}</option>";
	}
    exit(
        json_encode(array(
            'cats_table' => rm_generate_cats_table(),
            'items_table' => rm_generate_items_table(),
            'new_stadning_options' => $new_stadning_options,
            'new_ofta_options' => $new_ofta_options,
       ))
   );
}

function rm_generate_cats_table()
{
    global $wpdb;
    $adminurl = admin_url('admin.php');
    $names_query = $wpdb->get_results("SELECT `id`, `name` FROM `".$wpdb->prefix."ea_category` WHERE `parent` = 52", ARRAY_A);
    $names = array();
    foreach($names_query as $i)
    {
		$names[$i['id']] = $i['name'];
	}
    $cats = array('Standing:' => array('id' => 52, 'uid' => 'uaedid'), 'Hurt ofta?' =>  array('id' => 53, 'uid' => 'uoedid'));
    ob_start();
    foreach($cats as $key => $cat)
    {
        $ascat = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."ea_category` WHERE `parent` = {$cat['id']}"); ?>
        <tr>
            <td><?php echo '<b>&nbsp;&nbsp;'."$key".'</b>';  ?></td><td><?php echo '<b>'."$key".'</b>';  ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php 
		foreach($ascat as $sbcat)
		{ ?>
        <tr>
            <td style="padding-left:30px;"><?php echo $sbcat->name; ?></td>
            <td><?php echo $sbcat->description; ?></td>
            <td><?php echo $names[$sbcat->bind_to]; ?></td>
            <td><a href="<?php echo $adminurl; ?>?page=Hour&<?php echo $cat['uid'] ?>=<?php echo($sbcat->id); ?>">Edit</a></td>
            <td><a data-id="<?php echo $sbcat->id ?>" class="delete-hour" href="<?php echo $adminurl; ?>?page=Hour&uaeid=<?php echo($sbcat->id); ?>">Delete</a></td>
        </tr>
        <?php
        }
    }
    return ob_get_clean();
}

function rm_generate_items_table()
{
    global $wpdb;
    $adminurl = admin_url('admin.php');
    $names_query = $wpdb->get_results("SELECT `id`, `name` FROM `".$wpdb->prefix."ea_category` WHERE `parent` in(52,53)", ARRAY_A);
    $names = array();
    foreach($names_query as $i)
    {
		$names[$i['id']] = $i['name'];
	}
    $cats = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."ea_category` WHERE `conditions`  <> ''");
    ob_start();
    foreach($cats as $sbcat)
    {
        $conds = maybe_unserialize($sbcat->conditions);
        $belongs_to = array();
        foreach($conds as $id)
        {
			$belongs_to[] = $names[$id];
		}
        ?>
        <tr>
            <td style="padding-left:30px;"><?php echo $sbcat->name; ?></td>
            <td><?php echo $sbcat->description; ?></td>
            <td><?php echo  implode(', ', $belongs_to)?></td>
            <td><a href="<?php echo $adminurl; ?>?page=Hour&uiedid=<?php echo($sbcat->id); ?>">Edit</a></td>
            <td><a data-id="<?php echo  $sbcat->id ?>" class="delete-hour" href="<?php echo $adminurl; ?>?page=Hour&uaeid=<?php echo($sbcat->id); ?>">Delete</a></td>
        </tr>
    <?php 
    }
    return ob_get_clean();
}
// add_action('init', 'custom_table_example_languages');
$timestamp=1389999996;
wp_schedule_event($timestamp, 'daily', 'prefix_daily_event_hook'); 

function prefix_daily_event_hook()
{
	global $wpdb;
	$mailallrequest=$wpdb->get_results("SELECT * FROM `".$wpdb->prefix."bookings`");
	$ToDay=date("Y-m-d");
	foreach($mailallrequest as $mailone)
	{	
		if($mailone->SendMailStatus=='Enable')
		{
			$bookdats=$mailone->Display_date;
			$to=$mailone->email;
			$from=get_option('admin_email');;                
			$headers = 'MIME-Version: 1.0'."\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
			$headers .= 'From: <'.$from.'>'."\r\n".'Reply-To:'.$$from. "\r\n" ;
			$subject="Booking Reminder : Rent Hem Stockholm ";
			$message='';
			$message .='<br><h3>Hello Mr. '.$mailone->name.' </h3> Here is your Booking Details : <br><br>';
			$messageeach=
			'<b>Name : '.$mailone->name.'</b><br>'.
			'<b>Service Time : '.$mailone->timeval.'</b><br>'.
			'<b>Booking Date : '.$mailone->Display_date.'</b><br>'.
			'<b>Standing : </b>'.$mailone->standing.'<br>'.
			'<b>Size : </b>'.$mailone->size.'<br>'.
			'<b>Often : </b>'.$mailone->often.'<br>'.
			'<b>Postno : </b>'.$mailone->postno.'<br>';
			$message .=$messageeach;
			$datetime1 = new DateTime($ToDay);
			$datetime2 = new DateTime($bookdats);
			$interval = $datetime1->diff($datetime2);
			$Difftme=intval($interval->format('%R%a'));
			if($Difftme==1)
			{
				@mail($to, $subject, $message, $headers);
			}
		}
	}
}

function SendMailToAdmin($myName, $myFrom, $myTo, $myCCList, $myBCCList, $mySubject, $myMsg, $MailFormat)
{
    if(!isset($MailFormat)||($MailFormat!=0 && $MailFormat!=1))
    {
		$MailFormat = 1;
	}
    if($MailFormat==1)
    {
        $myMsgTop = "<table border='0' cellspacing='0' cellpadding='2' width='95%'>
		   <tr><td><font face='verdana' size='2'>";
        $myMsgBottom = "</font></td></tr></table>";
    }
    else
    {
        $myMsg = strip_tags($myMsg);
        $myMsg = str_replace("\t","",$myMsg);
        $myMsg = str_replace("&nbsp;","",$myMsg);
        $myMsgTop = "";
        $myMsgBottom = "";
    }
    $headers = "From: ".$myName." <".$myFrom.">\n";
    $headers .= "X-Sender: <".$myFrom.">\n";
    $headers .= "X-Mailer: PHP\n"; // mailer
    $header = "MIME-Version: 1.0\r\n";
    $header.= "Content-Type: text/html; charset=utf-8\r\n";
    $header.= "X-Priority: 1\r\n";
    $headers .= "Return-Path: <".$myFrom.">\n";  // Return path for errors
    if($MailFormat == 1)
    {
		$headers .= "Content-Type: text/html; charset=utf-8\n"; // Mime type
	}
    if(isset($myCCList)&& strlen(trim($myCCList))> 0)
    {
		$headers .= "cc: ".$myCCList."\n";
	}
    if(isset($myBCCList)&& strlen(trim($myBCCList))> 0)
    {
		$headers .= "bcc: ".$myBCCList."\n";
	}
    $receipient = $myTo;
    $subject = $mySubject;
    $message = $myMsgTop.$myMsg.$myMsgBottom;
    @mail($receipient,$subject,$message,$headers);
}

function rm_send_notification_emails($item)
{
    $standing=$item['standing'];
    $size=$item['size'];
    $often=$item['often'];
    $amount=$item['amount'];
    $Display_date=$item['Display_date'];
    $timeval=$item['timeval'];
    $name=$item['name'];
    $address=$item['address'];
    $postno=$item['postno'];
    $city=$item['city'];
    $kvm=$item['kvm'];
    $mobileno=$item['mobileno'];
    $email=$item['email'];
    $owner_email = get_option('admin_email');
    $headers = 'From:'.$email;
    $subject = 'Ny kundbokning : '.$name;
    $messageBody = "<table><tr><td width=400>";
    $messageBodyAD = "<table><tr><td width=400>";
    $messageBody .= '<p>Tack fĂśr din bokning.</p>'. "\n";
    $messageBodyAD .= '<p>Tack fĂśr din bokning.</p>'. "\n";
    $messageBody .= '<h3>Din bestĂ¤llning : </h3>';
    $messageBodyAD .= '<h3>Din bestĂ¤llning : </h3>';
    if($standing!='')
	{
        $messageBody .= '<p>StĂ¤dning: '.$standing.'</p>'."\n";
        $messageBodyAD .= '<p><b>StĂ¤dning:</b> '.$standing.'</p>'."\n";
    }
    if($often!='')
	{
        $messageBody .= '<p>Hur ofta?: '.$often.'</p>'."\n";
        $messageBodyAD .= '<p><b>Hur ofta?:</b> '.$often.'</p>'."\n";
    }
    if($size!='')
	{
        $messageBody .= '<p>Hur stort?: '.$size.'</p>'."\n";
        $messageBodyAD .= '<p><b>Hur stort?:</b> '.$size.'</p>'."\n";
    }
    if($amount!='')
	{
        $messageBody .= '<p>Kostnad efter RUT(kr): '.$amount.'</p>'."\n";
        $messageBodyAD .= '<p><b>Kostnad efter RUT(kr):</b> '.$amount.'</p>'."\n";
    }
    if($Display_date!='')
	{
        $messageBody .= '<p>Datum: '.$Display_date.'</p>'."\n";
        $messageBodyAD .= '<p><b>Datum:</b> '.$Display_date.'</p>'."\n";
    }
    if($timeval!='')
	{
        $messageBody .= '<p>Tidpunkt: '.$timeval.'</p>'."\n";
        $messageBodyAD .= '<p><b>Tidpunkt:</b> '.$timeval.'</p>'."\n";
    }
    $messageBody .= '</td><td>'."\n";
    $messageBodyAD .= '</td></tr>'."\n";
    $messageBody .= '<p>&nbsp;</p><h3>Dina uppgifter : </h3>';
    $messageBodyAD .= '<p>&nbsp;</p><h3>Dina uppgifter : </h3>';
    if($name!='')
	{
        $messageBody .= '<p>Namn : '.$name.'</p>'."\n";
        $messageBodyAD .= '<p><b>Namn :</b> '.$name.'</p>'."\n";
    }
    if($address!='')
	{
        $messageBody .= '<p>Gatuadress  : '.$address.'</p>'."\n";
        $messageBodyAD .= '<p><b>Gatuadress  :</b> '.$address.'</p>'."\n";
    }
    $messageBody .= '<p>Postnummer/Ort  : '.$postno." ".$city.'</p>'."\n";
    $messageBodyAD .= '<p><b>Postnummer/Ort   :</b> '.$postno." ".$city.'</p>'."\n";
    $messageBody .= '<p>UngefĂ¤rlig storlek pĂĄ bostad  : '.$kvm .'</p>'."\n";
    $messageBodyAD .= '<p><b>UngefĂ¤rlig storlek pĂĄ bostad   :</b> '.$kvm.'</p>'."\n";
    if($email!='')
	{
        $messageBody .= '<p>E-post: '.$email.'</p>'."\n";
        $messageBodyAD .= '<p><b>E-post:</b> '.$email.'</p>'."\n";
    }
	else
	{
        $headers = '';
    }
    $messageBody .= '<p>Mobilnr: '.$mobileno.'</p>'."\n";
    $messageBodyAD .= '<p><b>Mobilnr:</b> '.$mobileno.'</p>'."\n";
    $messageBody .= '</td></tr></table>'."\n";
    $messageBodyAD .= '</td></tr></table>'."\n";
    // var_dump(preg_replace("/>(.*):/", "<b>$1</b>", $messageBody));
    SendMailToAdmin($name,$email,$owner_email, "", "", $subject,"<p><big><big><big><big><b>NY BOKNING</b></big></big></big></big></p>".$messageBodyAD, 1);
    $owner_email = $email;
    $headers = 'From:'.get_option('admin_email');
    $subject = 'Din bokning Renthem.se';
    $messageBodyCust = '<p><img src="http://renthem.se/wp-content/themes/renthem/images/logo-11.png" /></p>
	<hr />'. "\n";
    // $messageBodyCust .= '<p>Tack fĂśr din bokning.</p>'. "\n";
    // $messageBodyCust .= '<h3>Din bestĂ¤llning : </h3>';
    $messageBodyCust .=$messageBody;
    $messageBody =$messageBodyCust;
    $messageBody .= '<p><img src="http://renthem.se/wp-content/themes/renthem/images/Sans-titre-3.png" /></p>';
    SendMailToAdmin("Admin",get_option('admin_email'),$owner_email, "", "", $subject,$messageBody, 1);
}



// Miniaturki - thumbnails
if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}

function sanitizeTitle( $title, $raw_title = '', $context = 'display' ) {
	$title = strip_tags($title);
	// Preserve escaped octets.
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	// Remove percent signs that are not part of an octet.
	$title = str_replace('%', '', $title);
	// Restore octets.
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}
		//$title = utf8_uri_encode($title, 200);
	}

	$title = strtolower($title);

	if ( 'save' == $context ) {
		// Convert nbsp, ndash and mdash to hyphens
		$title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );
		// Convert nbsp, ndash and mdash HTML entities to hyphens
		$title = str_replace( array( '&nbsp;', '&#160;', '&ndash;', '&#8211;', '&mdash;', '&#8212;' ), '-', $title );

		// Strip these characters entirely
		$title = str_replace( array(
			// iexcl and iquest
			'%c2%a1', '%c2%bf',
			// angle quotes
			'%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
			// curly quotes
			'%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
			'%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
			// copy, reg, deg, hellip and trade
			'%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
			// acute accents
			'%c2%b4', '%cb%8a', '%cc%81', '%cd%81',
			// grave accent, macron, caron
			'%cc%80', '%cc%84', '%cc%8c',
		), '', $title );

		// Convert times to x
		$title = str_replace( '%c3%97', 'x', $title );
	}

	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = str_replace('.', '-', $title);

	$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}

remove_filter('sanitize_title', 'sanitize_title_with_dashes', 10);
add_filter('sanitize_title', 'sanitizeTitle', 10, 3);

?>
