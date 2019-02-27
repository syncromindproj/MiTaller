<?PHP
class Model{
    function __construct(){
        $this->db = new Database();
    }

    function outputPDOerror($errorCode = 0) {
        $errors = [
          //'23000' => "Error: Duplicate Key",
          '23000' => "Error: La placa ya existe",
          '23001' => "Error: Some other error"
        ];
      
        return array_key_exists($errorCode, $errors) ? $errors[$errorCode] : 'Unknown Error!';
      }
}
?>