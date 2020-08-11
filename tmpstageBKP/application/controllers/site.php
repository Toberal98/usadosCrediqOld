<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site extends CI_Controller{

    function __construct() {

        parent::__construct();
        $this->load->model('data_model');
        $this->load->model('filter_model');
        $this->load->model('function_model');

        //Establece por default al pais El Salvador.
        if (!$this->session->userdata('pais')) {
            $this->session->set_userdata('pais', 1);
        }

        if (!$this->session->userdata('moneda')) {
            $this->data_model->SetMoneda();
        }
    }

    function index() {
        if (!$this->session->userdata('CategoriaActual')) {
            $this->session->set_userdata('CategoriaActual', 'todas');
        }
        $data['moneda'] = $this->session->userdata("moneda");
        date_default_timezone_set('America/El_Salvador');
        //Productos (Carros)
        $num_cars = $this->config->item('num_cars');
        //$limite = " LIMIT 0, ".$num_cars;
        $limite = "";
        $data['products'] = $this->filter_model->getProducts($limite);

        //Marcas
        $data['marcas'] = $this->data_model->getMarcasExistentes();

        //Categorias
        $data['categorias'] = $this->data_model->getCategories();

        $vista = $this->session->userdata('vista_actual');

        if ($vista == 1) {
            $data['vista1'] = TRUE; //mostramos vista 1
        } elseif ($vista == 2) {
            $data['vista2'] = TRUE; //mostramos vista 2
        } else {
            $data['vista1'] = TRUE; //mostramos vista 1
        }

        $data['filtro'] = TRUE; //mostramos vista filtro
        $data['template'] = 'template/principal.php';
        $this->load->view('template/masterpage.php', $data);
    }

    function filtrarAutosByAjax(){
        $cat = '';
        $tipoCuota = '';
        $cuoMin = '';
        $cuoMax = '';
        $marcas = '';
        
        if($this->input->post('categoria'))
        {
            $cat = $this->input->post('categoria');
        }
        if($this->input->post('tipoCuota'))
        {
            $tipoCuota = $this->input->post('tipoCuota');
        }
        if($this->input->post('cuoMin'))
        {
            $cuoMin = $this->input->post('cuoMin');
        }
        if($this->input->post('cuoMax'))
        {
            $cuoMax = $this->input->post('cuoMax');
        }
        if($this->input->post('marcas'))
        {
            $marcas = $this->input->post('marcas');
        }
        if($this->input->post('pagina'))
        {
            $pagina = $this->input->post('pagina');
        }
        $num_cars = $this->config->item('num_cars');
        //Descomentar en caso de necesitar limitar la cantidad de autos
        //$limite = " LIMIT ".($pagina * $num_cars ).", ". $num_cars;
        $limite = "";

        $datos = $this->filter_model->filtrarVehiculos($cat, $tipoCuota, $cuoMin, $cuoMax, $marcas, $limite);
        $item = "";
        $moneda = $this->session->userdata("moneda");
        $display = array(''.$tipoCuota.'' => "style='display: none;'");
        if($datos->num_rows() > 0){

            foreach($datos->result_array() as $car){
                //Cerramos php para trabajar con html y tratar mejor el echo del array
                $etiqueta = "";
                if($car['renting_aplica'] == "no"){ $etiqueta = "norenting"; }
                //pero si estan pidieno de compra
                if($tipoCuota =="compra"){ $etiqueta .= " incompra"; }
                $name = strtolower($car['marca']." ".$car['modelo']);
                $name = ucwords($name);
                $compra = $moneda.number_format($car['cuota_compra'], 2); 
                $renting = $moneda.number_format($car['cuota_renting'], 2);
?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 animated zoomIn <?php echo $etiqueta; ?>"
            onclick="llenarInfoCar('<?php echo $renting;?>','<?php echo $compra;?>','<?php echo $car['marca']; ?>', '<?php echo $car['modelo']; ?>')">
                <div class="car-item">
                    <div class="row">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <div class="informacion">
                            <span class="name"><?php echo $name; ?></span>
                            <span class="tipo"><?php echo $car['tipo']; ?></span>
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <div class="aranceles">
                                <div class="info-cuota" <?php echo $display['renting']; ?>>
                                    <span style="display:inline">Cuota Desde</span>
                                    <span class="price"><?php echo $compra; ?></span>
                                    /Mes
                                </div>
                                <div class="info-renting" <?php echo $display['compra']; ?>>
                                    <span style="display:inline">Renting Desde</span>
                                    <span class="price"><?php echo $renting; ?></span>
                                    /Diario
                                </div>
                            </div>
                        </div>
                    </div>
                    <img class="img-responsive" src="<?php echo base_url(); ?>index.php/site/getImage?id=<?php echo $car['id_automovil'] ?>" alt="<?php echo $titulo_auto; ?>">
                    <div class="explorer">
                        <button>Solicitar información <i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
            
<!--        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 animated zoomIn <?php echo $etiqueta; ?>">
                <div class="car-item">
                    <div class="name"><?php echo $car['marca']; ?> <?php echo $car['modelo']; ?></div>
                    <img class="img-responsive" src="<?php echo base_url(); ?>index.php/site/getImage?id=<?php echo $car['id_automovil'] ?>" alt="<?php echo $titulo_auto; ?>">
                    <div class="content">
                        <div class="cuota-renting">
                            <table class="info-cuota" <?php echo $display['renting']; ?> >
                                <tr><td><span>Cuota</span></td><td></td></tr>
                                <tr><td>Desde: </td><td> <strong><?php echo $moneda; ?><?php echo number_format($car['cuota_compra'], 2); ?></strong></td></tr>
                            </table>
                            <table class="info-renting" <?php echo $display['compra']; ?>>
                                <?php if($car['renting_aplica'] == "si"): ?>
                                <tr><td><span>Renting</span></td><td></td></tr>
                                <tr><td>Desde: </td><td> <strong> <?php echo $moneda; ?><?php echo number_format($car['cuota_renting'], 2); ?> </strong>* Diario</td></tr>
                                <?php else: ?>
                                <tr><td><span>Renting</span></td><td></td></tr>
                                <tr><td>Desde: </td><td> <strong>no aplica</strong></td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                        <div class="explorer">
                            <button onclick="
                            llenarInfoCar('<?php echo $car['marca']; ?>',
                            '<?php echo $car['modelo']; ?>')">Solicitar informaciÃ³n <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>-->
        <?php
            }
        }
    }

    function getImage(){
        $id = $this->input->get("id");
        $url = $this->filter_model->getImageUrl($id);
        header("Location: $url");
    }

    function about() {
        echo 'about page';
    }

    function process_url($id) {
        $this->load->model('secure_model');
        $url = $this->secure_model->getBannerURL($id);

        if ($url) {
            redirect($url);
        } else {
            redirect(base_url());
        }
    }

    function changePais($pais) {

        $this->session->set_userdata('pais', $pais);

        $this->data_model->SetMoneda();

        redirect(base_url());
    }

    function contacto() {
        $data['template'] = 'template/contacto.php';
        $this->load->view('template/masterpage.php', $data);
    }

    function proccessContact() {
        $marca = $this->input->post('marca');
        $modelo = $this->input->post('modelo');
        $opcion = $this->input->post('opcion');
        $cuota = $this->input->post('cuota');

        $nombre = $this->input->post('name');
        $telefono = $this->input->post('phone');
        $email = $this->input->post('email');
        $consulta = htmlentities($this->input->post('consulta'));

        $datos = array(
            'marca' => $marca,
            'modelo' => $modelo,
            'opcion' => $opcion,
            'cuota' => $cuota,
            'tipo' => 'info-car',
            'to' => 'josefloresvasquez@gmail.com',
            'nombre' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'consulta' => $consulta
        );

        $clave = "";

        $this->session->set_flashdata('msg', 'Solicitud de información enviada correctamente.');
        if ($this->function_model->enviarMail($datos)) {
            redirect(base_url() . 'index.php');
        } else {
            redirect(base_url() . 'index.php');
        }

        $this->load->view('template/masterpage.php', $data);
    }
 
    function change_vista($tipo){
        $this->session->set_userdata('vista_actual', $tipo);
        redirect(base_url());
    }

    function login() {
        $this->load->model('secure_model');
        $username = $this->input->post('user');
        $password = $this->input->post('pwd');

        //$template = $this->input->post('template');

        $log = $this->secure_model->login($username, $password);
 
        if ($this->secure_model->login($username, $password)) {
            redirect('index.php/car');
        } else {

            if ($this->secure_model->checkEmail($username)) {
                $user_temp = $this->data_model->get_estado_user($username);
                if (isset($user_temp['estado'])) {
                    if (md5($user_temp['estado']) == md5($username)) {
                        $data['error_login2'] = 'Su cuenta no ha sido activada';
                    }
                }
            }
            $data['error_login'] = 'Email o Password incorectos';
            $data['tipo'] = "30";

            //$data['template'] = $template;
            $this->load->view('template/login', $data);
        }
    }

    function logout() {
        $this->session->destroy();
        redirect(base_url());
    }
}
?>