<?php

class user {
    private $_id;
    public $_login;
    public $_email;
    public $_firstname;
    public $_lastname;
    private $_link;

/////////////////////// construct

    public function _constuct () {}

/////////////////////// register

    public function _register ($_login, $_password, $_email, $_firstname, $_lastname) {
        $_login = htmlspecialchars($_login);
        $_password = htmlspecialchars($_password);
        $_email = htmlspecialchars($_email);
        $_firstname = htmlspecialchars($_firstname);
        $_lastname = htmlspecialchars($_lastname);

        $this->_login = $_login;
        $this->_password = $_password;
        $this->_email = $_email;
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;

        $link = mysqli_connect('localhost','root','', 'classes');
        $this->_link = $link;
        $SQL = "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$_login', '$_password', '$_email', '$_firstname', '$_lastname')";
        mysqli_query($link,$SQL);
        $query = mysqli_query($link, "SELECT * from utilisateurs WHERE login = '$_login'");
        $resultat = mysqli_fetch_assoc($query);
        return $resultat;
    }

/////////////////////// connect

    public function _connect ($_login, $_password) {
        $_login = htmlspecialchars($_login);
        $_password = htmlspecialchars($_password);

        $this->_login = $_login;
        $this->_password = $_password;

        $link = mysqli_connect('localhost','root','', 'classes');
        $this->_link = $link;
        $SQL = "SELECT * FROM utilisateurs WHERE login = '$_login'";
        $query = mysqli_query($link, $SQL);
        $resultat = mysqli_fetch_assoc($query);
        
        
        if( $resultat == null) {
            echo "il y a une erreur.";
            $this->_disconnect();
        }
        else{
            if($_password == $resultat['password']){
                $this->_login = $resultat['login'];
                $this->_password = $resultat['password'];
                $this->_email = $resultat['email'];
                $this->_firstname = $resultat['firstname'];
                $this->_lastname = $resultat['lastname'];
                echo 'vous êtes bien connecté ' . $_login;
                return $resultat;
            }else{
                echo 'il y a une erreur.';
                $this->_disconnect();
            }
        }
    }

/////////////////////// disconnect

    public function _disconnect() {
        $this->_login = '';
        $this->_password = '';
        $this->_email = '';
        $this->_firstname = '';
        $this->_lastname = '';
        echo 'vous êtes bien déconnecté.';
    }

/////////////////////// delete

    public function _delete () {
        $_login = $this->_login;
        
        $link = mysqli_connect('localhost','root','', 'classes');
        $this->_link = $link;
        $SQL = "DELETE FROM utilisateurs WHERE login = '$_login'";
        mysqli_query($link, $SQL);
            echo  'vous êtes bien mort.';
    }

/////////////////////// update

    public function _update ($_login, $_password, $_email, $_firstname, $_lastname) {
        $_login = htmlspecialchars($_login);
        $_password = htmlspecialchars($_password);
        $_email = htmlspecialchars($_email);
        $_firstname = htmlspecialchars($_firstname);
        $_lastname = htmlspecialchars($_lastname);

        $_ancienlog = $this->_login;
        $this->_login = $_login;
        $this->_password = $_password;
        $this->_email = $_email;
        $this->_firstname = $_firstname;
        $this->_lastname = $_lastname;
        
        $link = mysqli_connect('localhost','root','', 'classes');
        $this->_link = $link;
        $SQL = "UPDATE utilisateurs SET login='$_login', password='$_password', email='$_email', firstname='$_firstname', lastname='$_lastname' WHERE login ='$_ancienlog'";
        echo $SQL;
        mysqli_query($link, $SQL);

        echo '<br>les info ont bien été changé.';
        
    }

/////////////////////// isConnected

    public function _isConnected() {
        // echo $this->_login;
        if(!($this->_login == '')) {
            return true;
        }
        else{
            return false;
        }
    }

/////////////////////// getAllInfos

    public function _getAllInfos () {
        $link = mysqli_connect('localhost','root','', 'classes');
        $this->_link = $link;
        $SQL = "SELECT * FROM utilisateurs";
        $query = mysqli_query($link, $SQL);
        $resultat = mysqli_fetch_assoc($query);
        return ['login' => $this->_login,
                'password' => $this->_password,
                'email' => $this->_email,
                'firstname' => $this->_firstname,
                'lastname' => $this->_lastname];
    }

/////////////////////// getLogin

    public function _getLogin () {
        return ['login' => $this->_login];
    }

/////////////////////// getEmail

    public function _getEmail () {
        return ['email' => $this->_email];
    }

/////////////////////// getFirstname

    public function _getFirstname () {
        return ['firstname' => $this->_firstname];
    }

/////////////////////// getLastname

    public function _getLastname () {
        return ['lastname' => $this->_lastname];
    }
}
?>