<?php
require_once 'functions.php';
require_once 'db_connection.php';

/**
 * User class that contains user data and controles user loggin and logout
 */
class User {
    private $db_conn,
            $data,
            $sessionName,
            $isLoggedIn;

    /**
     * Constructor that checks to see if user is logged in, if
     * user is logged in it returns that user therewise constructor
     * searches for user from db. eg $user = new User() // gets current
     * user thats logged in if there is one, or $user = new User(4)
     * // gets user a user_id = 4 from db, or $user = new User('id4766wa')
     * // gets user with a username = id4766wa from db.
     * @param string [$user = null] leave blank to get current user,
     * otherwise give it a param of a user_id or a username.
     * @author Gary
     */
    public function __construct($user = null) {
        $this->db_conn = SqlManager::getInstance();
        $this->sessionName = $GLOBALS['config']['session']['session_name'];
        if (!$user) {
            if (Session::exists($this->sessionName)) {
                $user = Session::get($this->sessionName);
                if ($this->find($user)) {
                    $this->isLoggedIn = true;
                }
            }
        } else {
            $this->find($user);
        }
    }

    /**
     * Creates a new user in the database from an array of parameters
     * @param array paramerter values
     */
    public function create($params = array()) {
        $sql = "INSERT INTO users (user_id, username, password, fname, lname, email, phone_number, places_fk_id) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);";
        if (!$this->db_conn->query($sql, $params)) {
            throw new Exception("Error creating account!");
        }
    }

    /**
     * Verifies user loggin informantion is correct then creates session
     * @author Gary
     * @param  string [$username = null] username submitted by user
     * @param  string [$password = null] password submitted by user
     * @return boolean  true if loggin was successful, else false
     */
    public function login($username = null, $password = null, $remember) {
        $user = $this->find($username);

        if ($user) {
            if(password_verify($password, $this->data()->password)) {
                Session::put($this->sessionName, $this->data()->user_id);
                if ($remember) {
                    $hash = hash('sha256', uniqid() . mcrypt_create_iv());
                    $hashCheck = $this->db_conn->query("SELECT * FROM login_attempts WHERE user_fk_id = ?", array($this->data()->user_id));
                    if (!$hashCheck->getCount()) {
                        $this->db_conn->query("INSERT INTO login_attempts (attempt_id, attempt_success, session_id, )")
                    }


                    $cookie = new cookie
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Searches db for user
     * @author Gary
     * @param  string [$user = null] enter a user_id or username to search
     * @return boolean  true if a user match was found else false
     */
    public function find($user = null) {
        if ($user != null) {
            $field = (is_numeric($user)) ? 'user_id' : 'username';
            $sql = "SELECT * FROM users WHERE " . $field . " = ?";
            $params = array($user);
            $result = $this->db_conn->query($sql, $params);
            if ($result->getCount() > 0) {
                $this->data = $result->getResult()[0];
                return true;
            }
        }
        return false;
    }

    /**
     * Gets user data information
     * @author Gary
     * @return array of data about user from db
     */
    public function data() {
        return $this->data;
    }

    /**
     * Checks to see if user is logged in
     * @author Gary
     * @return boolean true if user is logged in, else false
     */
    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    /**
     * Causes the user to logout
     * @author Gary
     */
    public function logout() {
        Session::delete($this->sessionName);
    }
}

/**
 * Class represents an item for sale
 */
class Item { // TODO: need to implement
	private $db_conn;

    public function __construct($item = null) {
        $this->db_conn = SqlManager::getInstance();
    }

    public function create($params = array()) {
        $sql = "";
        if (!$this->db_conn->query($sql, $params)) {
            throw new Exception("Error creating item!");
        }
    }
}

/**
 * Class represents a place
 */
class Place { // TODO: need to implement
    private $db_conn;

    public function __construct($place = null) {
        $this->db_conn = SqlManager::getInstance();
    }

    public function create($params = array()) {
       $sql = "INSERT INTO places (place_id, address, city, state, zip_code, country) VALUES (NULL, ?, ?, ?, ?, ?);";
        if (!$this->db_conn->query($sql, $params)) {
            throw new Exception("Error creating place!");
        }
    }
}

/**
 * Class represents a garageSale
 */
class GarageSale { // TODO: need to implement
	 private $db_conn;

    public function __construct($place = null) {
        $this->db_conn = SqlManager::getInstance();
    }

    public function create($params = array()) {
       $sql = "";
        if (!$this->db_conn->query($sql, $params)) {
            throw new Exception("Error creating Garage Sale!");
        }
    }
}

/**
 * Class to redirect you to a different page.
 */
class Redirect {
    /**
     * Redirects to page given as parameter
     * eg. Redirect::page('index.php');
     * @author Gary
     * @param string [$location = null] page to go to
     */
    public static function page($location = null) {
        if ($location != null) {
            if(is_numeric($location)) {
                switch($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include '404.php';
                        exit();
                    break;
                }
            }
            header('Location: ' . $location);
            exit();
        }

    }
}

/**
 * Abstract class PageBuilder that has methods to the navbar, footer, and tables.
 */
abstract class PageBuilder {
	/**
	 * Gets the navbar for the page
	 * eg. PageBuilder::getHeader();
	 * @author Gary
	 */
	public function getHeader() {
		$this->active = '';
		$this->title = '';
		$this->header = '';
        $user = new User();
		$this->logged_in = $user->isLoggedIn(); // TODO: change to dynamic
		$array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
		$page_name = array_pop($array);
		switch($page_name) {
			case "index.php":
				$this->active = 'index';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "yourSales.php":
				$this->active = 'yourSales';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "items.php":
				$this->active = 'items';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "createAccount.php":
				$this->active = 'createAccount';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			case "otherSales.php":
				$this->active = 'otherSales';
				$this->header = $this->makeHeader($this->active, $this->title, $this->logged_in);
				echo $this->header;
				break;
			default:
				$active = '';
				$title = '';
				$header = 'add Page';
				echo $this->header;
		}
	}

	/**
	 * Gets the footer for the page
	 * eg. PageBuilder::getFooter();
	 * @author Gary
	 */
	static function getFooter() {
	echo <<<CONTENT
		<div class="container text-center">
			<h4>Contact Us</h4>
			<div>
				<div class="contact-info">Phone Number: 612 978 5555<span class="glyphicon glyphicon-earphone"></span></div>
				<div class="contact-info">Email Address: GSalesStaff@Gsales.net<span class="glyphicon glyphicon-envelope"></span></div>
			</div>
		</div>
CONTENT;
    }

	/**
	 * Gets the tile for the page
	 * eg. PageBuilder::getTitle();
	 * @author Gary
	 */
	static function getTitle() {
		$array = explode('/', sanitizeInput($_SERVER['PHP_SELF']));
		$page_name = array_pop($array);
		$array = array_reverse(explode('.',$page_name));
		$title = ucfirst(array_pop($array));
		echo $title . " | GSale";
	}

	/**
	 * Makes the header for the page
	 * @author Gary
	 * @param  string $active    sets the active class in header so user can tell what page they are on
	 * @param  string $title     of page
	 * @param  boolean $logged_in true if the user is logged in else false
	 * @return string html text for header
	 */
	protected function makeHeader($active, $title, $logged_in) {
		$header = '';
		if (!$logged_in) {
			$header = '
						<nav class="navbar navbar-expand navbar-inverse navbar-fixed-top">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								<a class="navbar-brand" href="index.php"><img src="../img/garage_logo_final.png" /></a>
								</div>
								<div class="collapse navbar-collapse" id="MyNavbar">
									<ul class="nav navbar-nav navbar float-left">
									' . $this->getActive($active) . '
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a href="#">
												<form class="navbar-form navbar-right" role="search">
													<div class="input-group">
														<input id="search" type="text" class="form-control" placeholder="Search" name="search">
														<div class="input-group-btn">
															<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
														</div>
													</div>
												</form>
											</a>
										</li>
										<li><a href="#"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
										<li><a href="createAccount.php">Create Account</a></li>
									</ul>
								</div>
							</div>
						</nav>';
		} else {
			$header = '
						<nav class="navbar navbar-expand navbar-inverse navbar-fixed-top">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								<a class="navbar-brand" href="#"><img src="../img/garage_logo_final.png" /></a>
								</div>
								<div class="collapse navbar-collapse" id="MyNavbar">
									<ul class="nav navbar-nav navbar float-left">
									' . $this->getActive($active) . '
									</ul>
									<ul class="nav navbar-nav navbar-right">
										<li>
											<a href="#">
												<form class="navbar-form navbar-right" role="search">
													<div class="input-group">
														<input id="search" type="text" class="form-control" placeholder="Search" name="search">
														<div class="input-group-btn">
															<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
														</div>
													</div>
												</form>
											</a>
										</li>
										<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="yourSales.php">My Sales</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">My Items</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">Prefered Items</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">One more separated link</a></li>
										</ul>
									</li>
									<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
									</ul>
								</div>
							</div>
						</nav>';
		}
		return $header;
	}

	/**
	 *
	 * @param  string $active page
	 * @return string html of with class of active page
	 */
	protected function getActive($active) {
		$html = '';
		$active_index = '';
		switch($active) { // TODO: add other cases
			case "index":
				$active_index = 0;
				break;
			case "otherSales":
				$active_index = 1;
				break;
			case "items":
				$active_index = 2;
				break;
			default:
				$active_index = 0;
		}

		$pages = array('index.php', 'otherSales.php', 'items.php');
        $selections = array('Home', 'Sales', 'Items');

		for ($i = 0; $i < (count($pages) * 2); $i++ ) {
			if ($i % 2 == 0 && $i == ($active_index * 2)) {
				$html .= '<li class="active"><a href="' . $pages[$active_index] . '">' . $selections[$active_index] . '</a></li>';
			} else if ($i % 2 == 0){
				$html .= '<li class=""><a href="' . $pages[($i * .5)] . '">' . $selections[($i * .5)] . '</a></li>';
			} else {
				$html .= '<li role="separator" class="divider"></li>';
			}
		}
        return $html;
	}

    /**
     * TODO: To be implemented by subclasses
     */
    abstract protected function getTable();

    /**
     * TODO: To be implemented by subclasses
     */
    abstract protected function getTableData();
}

 /**
  * TODO: To be implemented by subclasses
  */
class IndexPage extends PageBuilder {
    protected function getTable() {

    }

    protected function getTableData() {

    }
}
 /**
  * TODO: To be implemented by subclasses
  */
class RegisterPage extends PageBuilder {
    protected function getTable() {

    }

    protected function getTableData() {

    }

}
 /**
  * TODO: To be implemented by subclasses
  */
class SalesPage extends PageBuilder {
    protected function getTable() {

    }

    protected function getTableData() {

    }
}
 /**
  * TODO: To be implemented by subclasses
  */
class ItemsPage extends PageBuilder {
    protected function getTable() {

    }

    protected function getTableData() {

    }
}

/**
 * Class is used to vaidate user input and return any errors
 * in the input if any exist.
 */
class Validation {
    private $passed,
            $errors,
            $db_conn;

    /**
     * Constructor that gets connection to db and intizes class variables
     */
    public function __construct() {
        $this->passed = false;
        $this->db_conn = SqlManager::getInstance();
        $this->errors = array();
    }

   /**
    * Checks to make sure ever rule on input passed
    * eg.
    * @return Validation returns itself so you can check for errors
    */
    public function check($submit_method,  $tests = array()) {
        foreach($tests as $test => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = sanitizeInput($submit_method[$test]);
                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$test} is required");
                } else if(!empty($value)) {
                    switch($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$test} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                         case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$test} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                         case 'matches':
                            if ($value != sanitizeInput($submit_method[$rule_value])) {
                                $this->addError("{$rule_value} must match {$test}");
                            }
                            break;
                         case 'unique':
                            $check = $this->db_conn->query("SELECT * FROM {$rule_value} WHERE {$test} = '{$value}'", array());
                            if ($check->getCount() > 0) {
                                $this->addError("{$test} alread exists.");
                            }
                            break;
                         case 'email':
                            $email_address = sanitizeInput($submit_method[$rule]);
                            if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("{$test} was not a valid email.");
                            }
                            break;
                         case 'phone':
                            $phone_number = sanitizeInput($submit_method[$rule]);
                            if (false) { //TODO: need to implement
                                $this->addError("Phone number was not valid.");
                            }
                            break;
                        case 'address': // TODO: need to implement

                            break;
                    }
                }
            }
        }

        if (empty($this->errors)) {
            $this->passed = true;
        }
        return $this;
    }

    /**
     * Adds an error to the list of errors
     * @param string $error to be added to error array
     */
    private function addError($error) {
        $this->errors[] = $error;
    }

    /**
     * Gets the list of errors
     * @return array of errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Returns true if all test on input were passed else
     * it returns false.
     * @return boolean true if passed, else false
     */
    public function passed() {
        return $this->passed;
    }
}

/**
 * Class represents a random token string to prevent cross site attacks
 */
class Token {
    /**
     * Generates a random token string
     * @author Gary
     * @return string token string generated
     */
    public static function generate() {
        return Session::put($GLOBALS['config']['session']['token_name'], md5(uniqid()));
    }

    /**
     * Checks to see if two tokens match
     * @author Gary
     * @param  string $token to be checked
     * @return boolean  true if tokens match, else false
     */
    public static function check($token) {
        $tokenName = $GLOBALS['config']['session']['token_name'];

        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}

/**
 * Class that handles seeion mangagement
 */
class Session {
    /**
     * Deletes a session variable
     * @author Gary
     * @param string $name of session var to delete
     */
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Checks to see if a session exists
     * @author Gary
     * @param  string $name of session var to check
     * @return boolean true if the session exists, else false
     */
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Puts a value in session variable
     * @author Gary
     * @param  string $name  of session variable
     * @param  string $value to put in session variable
     * @return string value inserted
     */
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /**
     * Gets a session variable
     * @author Gary
     * @param  string $name of sesion variable to get
     * @return string value of session variable
     */
    public static function get($name) {
        return $_SESSION[$name];
    }

    /**
     * Sets a one time message
     * @author Gary
     * @param  string $name           of session variable
     * @param  string [$message = ''] message to be saved
     * @return string value of session variable
     */
    public static function flash($name, $message = '') {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $message);
        }
    }
}

class cookie {

    public static function exists($name) {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    public static function get($name) {
        return $_COOKIE[$name];
    }

    public static function put($name, $value, $expiry) {
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    public static function delete($name) {
        self::put($name, '' , time()-1);
    }
}

?>
