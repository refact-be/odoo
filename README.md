# Odoo client

Installation:

    composer require refact-be/odoo
    
Usage: 

    use Refact\Odoo\Odoo;
    
    $url = 'http://localhost:8069';
    $credentials = ['database_name', 2, 'admin_pass'];
    
    $odoo = new Odoo($url, $credentials);
    
    $params = ['res.users', 'search_read', [], ['fields' => ['name']]];
    $users = $odoo->rpc('object', 'execute_kw', $params);
    
    var_dump($users);

Output:

    array(1) {
      [0]=>
      array(2) {
        ["id"]=>
        int(2)
        ["name"]=>
        string(13) "Administrator"
      }
    }
