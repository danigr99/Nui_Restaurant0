<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaginaPrincipal
 *
 * @author Daniel
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Reservas;
use App\Entity\Menus;
use App\Entity\Productos;
use App\Entity\Categorias;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PaginaPrincipal extends AbstractController {
    
    /**
     * @Route("/", name="index")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $usuario = $this->getUser();
        
        $noUser = '';
        if($usuario != NULL) {
            $noUser = $usuario->getUsername();
        }
        
        return $this->render('main/index.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'noUser' => $noUser
        ]);
    }
    
    /**
     * @Route("/contacto", name="contacto")
     */
    public function contacto(AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $usuario = $this->getUser();
        $noUser = '';
        if($usuario == NULL) {
            $noUser = '';
        }elseif ($usuario != NULL) {
            $noUser = $usuario->getUsername();
        }
        
        return $this->render('contactos/contacto.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'noUser' => $noUser
        ]);
    }
    
    /**
     * @Route("/contacto/enviado", name="contactoEnviar")
     */
    public function enviar(Request $request, AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $nombre = $request->request->get('name');
        
        if($nombre == '') {
            $nombre = 'Anonimo';
        }
        
        $dni = $request->request->get('dni');

        $email = $request->request->get('email');
        $mensaje = $request->request->get('mensaje');
        $cabeceras = 
            'From:'.$email . "\r\n" .
            'Reply-To: danielgarciaramos2@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        mail(
            "danielgarciaramos2@gmail.com",
            "Mensaje de ".$nombre,
            "De: ".$email."\n".$mensaje,
            $cabeceras
        );
        
        return $this->render('contactos/enviado.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError
        ]);;
    }
    
    /**
     * @Route("/reservas", name="reservas")
     */
    public function reservas(Request $request, AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $em = $this->getDoctrine()->getManager();
        $reserva = new Reservas();
        $usuario = $this->getUser();
        
        $menus = $em->getRepository(Menus::class)->findAll();
        
        $reservas = 0;
        
        if($usuario != null) {
            $reservas = $em->getRepository(Reservas::class)->findBy(['nombre_usuario' => $usuario->getUsername()]);
        }else {
            $reservas = '';
        }
        
        $noUser = '';
        if($usuario == NULL) {
            $noUser = 'Debe estar logueado para poder reservar';
        }elseif ($usuario != NULL) {
            $noUser = $usuario->getUsername();
        }
        
        return $this->render('reservas/reservas.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'noUser' => $noUser,
            'usuario' => $usuario,
            'menus' => $menus,
            'reservas' => $reservas,
            'noUser' => $noUser
        ]);
    }
    
    /**
     * @Route("/reservas/guardada", name="reservaGuardada", methods={"GET", "POST"})
     */
    public function guardarReserva(Request $request, AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $em = $this->getDoctrine()->getManager();
        $reserva = new Reservas();
        $usuario = $this->getUser();
        
        $error = false;
        
        $menu = $request->request->get("menu");
        $menuId = $em->getRepository(Menus::class)->findBy(['primer_plato' => $menu]);
        
        if($menu == 'Elige el menú') {
            $reserva->setMenu(null);
        }else if(empty($menuId)) {
            $error = true;
        }else{
            $reserva->setMenu($menuId[0]);
        }
        
        $reserva->setFecha($request->request->get("date"));
        $reserva->setNumPersonas($request->request->get("personas"));
        $reserva->setUsuario($usuario);
        $reserva->setNombreUsuario($usuario->getUsername());
        $em->persist($reserva);
        $em->flush();
        
        $noUser = '';
        if($usuario == NULL) {
            $noUser = 'Debe estar logueado para poder reservar';
        }
        
        return $this->render('reservas/guardar.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'error2' => $error,
        ]);
    }
    
    
    /**
     * @Route("/menus", name="menus")
     */
    public function menus(AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository(Menus::class)->findAll();
        
        $productos = $em->getRepository(Productos::class)->findAll();
        
        $usuario = $this->getUser();
        $rol = '';
        if($usuario != null) {
            $rol = $usuario->getRoles();
            if(!empty($rol)) {
                $rol = $rol[0];
            }
        }
        
        $noUser = '';
        if($usuario == NULL) {
            $noUser = '';
        }elseif ($usuario != NULL) {
            $noUser = $usuario->getUsername();
        }
        
        return $this->render('products/menus.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'menus' => $menus,
            'noUser' => $noUser,
            'rol' => $rol,
            'productos' => $productos
        ]);
    }
    
    /**
     * @Route("/menus/guardar", name="guardarMenus", methods={"GET", "POST"})
     */
    public function guardarMenus(Request $request, AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $userError = '';
        
        $em = $this->getDoctrine()->getManager();
        $menu = new Menus();
        
        $menu->setEntrante($request->request->get("entrante"));
        $menu->setPrimerPlato($request->request->get("primerPlato"));
        $menu->setSegundoPlato($request->request->get("segundoPlato"));
        $menu->setPostre($request->request->get("postre"));
        $menu->setCoste($request->request->get("precio"));
        $em->persist($menu);
        $em->flush();
        
        return $this->render('products/guardarMenu.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'userError' => $userError,
        ]);
    }
    
    /**
     * @Route("/categorias", name="categorias")
     */
    public function categorias(AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->getRepository(Categorias::class)->findAll();
        $productos = $em->getRepository(Productos::class)->findAll();
        
        foreach ($categorias as $cat) {
            $categoria = $em->getRepository(Categorias::class)->findBy(['id' => $cat->getId()]);
            $producto = $em->getRepository(Productos::class)->findBy(['id_categoria' => $cat->getId()]);
            $numProductos = count($producto);

            $categoria[0]->setCantidadProductos($numProductos);
            
            $em->persist($categoria[0]);
            $em->flush();
        }
        
        $usuario = $this->getUser();
        $rol = '';
        if($usuario != null) {
            $rol = $usuario->getRoles();
            if(!empty($rol)) {
                $rol = $rol[0];
            }
        }
        
        $usuario = $this->getUser();
        $noUser = '';
        if($usuario == NULL) {
            $noUser = '';
        }elseif ($usuario != NULL) {
            $noUser = $usuario->getUsername();
        }
        
        return $this->render('products/categorias.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'categorias' => $categorias,
            'productos' => $productos,
            'noUser' => $noUser,
            'rol' => $rol
        ]);
    }
    
    /**
     * @Route("/categorias/guardar", name="guardarProducto")
     */
    public function guardarProducto(Request $request, AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $userError = '';
        
        $em = $this->getDoctrine()->getManager();
        $producto = new Productos();
        
        $categoria = $request->request->get("categoria");
        $categorias = $em->getRepository(Categorias::class)->findBy(['nombre' => $categoria]);
        
        $producto->setIdCategoria($categorias[0]);
        $producto->setNombre($request->request->get("nombre"));
        $producto->setAlergenos($request->request->get("alergenos"));
        $producto->setDescripcion($request->request->get("descripcion"));
        $producto->setPrecio($request->request->get("precio"));
        $em->persist($producto);
        $em->flush();
        
        return $this->render('products/guardarProducto.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'userError' => $userError,
        ]);
    }
    
    /**
     * @Route("/registrar", name="registrar")
     */
    public function registrar(AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $usuario = $this->getUser();
        $rol = '';
        if($usuario != null) {
            $rol = $usuario->getRoles();
            if(!empty($rol)) {
                $rol = $rol[0];
            }
        }
        
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository(User::class)->findAll();
        
        return $this->render('registration/index.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'security' => 'SecurityController',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'usuarios' => $usuarios,
            'rol' => $rol
        ]);
    }
    
    /**
     * @Route("/registrar/guardar", name="guardar", methods={"GET", "POST"})
     */
    public function guardarRegistro (Request $request, AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $passwordEncoder): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $userError = '';
        
        $em = $this->getDoctrine()->getManager();
        $usuario = new User();
        
        $userRecogido = $request->request->get("username");
        $userBD = $em->getRepository(User::class)->findBy(['username' => $userRecogido]);
        
        if($userRecogido == $userBD) {
            $userError = '* Usuario existente *';
        }else {
            $encoded = $passwordEncoder->encodePassword($usuario, $request->request->get("password"));
        
            $usuario->setUsername($request->request->get("username"));
            $usuario->setPassword($encoded);
            $usuario->setNombre($request->request->get("name"));
            $usuario->setApellidos($request->request->get("lastname"));
            $usuario->setFechaNacimiento($request->request->get("birthday"));
            $usuario->setDni($request->request->get("dni"));
            $usuario->setSexo($request->request->get("gender"));
            $usuario->setEmail($request->request->get("email"));
            $usuario->setAlergias($request->request->get("alergias"));
            
            if($request->request->get("rol") == null) {
                $usuario->setRoles(['']);
            }else {
                $usuario->setRoles([$request->request->get("rol")]);
            }
            
            $em->persist($usuario);
            $em->flush();
        }
        
        return $this->render('registration/guardar.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'userError' => $userError
        ]);
    }
    
    /**
     * @Route("/navegacion", name="navegacion")
     */
    public function navegacion(AuthenticationUtils $authenticationUtils): Response {
        
        // get the login error if there is one
        $loginError = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $usuario = $this->getUser();
        
        $noUser = '';
        if($usuario != NULL) {
            $noUser = $usuario->getUsername();
        }
        
        return $this->render('responsive/asideResponsive.html.twig', [
            'pagina_principal' => 'PaginaPrincipal',
            'last_username' => $lastUsername,
            'error' => $loginError,
            'noUser' => $noUser
        ]);
    }
    
    
}
