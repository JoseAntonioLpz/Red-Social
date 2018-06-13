<?php

class ControladorPost extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        echo 'index post';
    }
    
    function savePost(){
        if($this->isProfile()){
            $texto = Request::read('texto');
            $media = Request::read('media');
            if($media){
                $m = 1;
            }else{
                $m = 0;
            }
            
            $post = new Post(0, $this->getPerfil()->getId(), $texto, $m);
            $res = $this->getModel()->savePost($post);
            
            if($res && $m){
                $fileUpload = new FileUpload('media', $res, './media', 2 * 1024 * 1024);
                $r = $fileUpload->upload();
                if($r){
                    $url = $fileUpload->getTarget() . '/' . $res;
                    $file = new Media(0, $res, $url);
                    $r = $this->getModel()->saveMedia($file);
                }
            }
            /*if($res && $r){
                $this->getModel()->setDato('data', true);
            }else*/if($res){
                $post = $this->getModel()->getPostCompleteById($res);
                $this->getModel()->setDato('data', $post);
            }else{
                $this->getModel()->setDato('data', false);
            }
            
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function obtainPost(){
        if($this->isProfile()){
            $page = Request::read('page');
            if($page < 1 || !$page){
                $page = 1;
            }
            $rows = $this->getModel()->postCount($this->getPerfil()->getId());
            
            $pagination = new Pagination($rows , $page, 40);
            $a = $pagination->getOffset();
            $b = $pagination->getRpp();
            
            $posts = $this->getModel()->obtainPost($this->getPerfil()->getId(), $a, $b);
            $this->getModel()->setDato('data', $posts);
            $this->getModel()->setDato('pagina', $page);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function obtainSinglePost(){
        if($this->isProfile()){
            $id = Request::read('id');
            $posts = $this->getModel()->obtainSinglePost($id);
            $this->getModel()->setDato('data', $posts);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function viewImagePost(){
        if($this->isProfile()){
            $id = Request::read('id');
            $post = $this->getModel()->getPostById($id);
            
            if($post->getMedia() ===  '1'){
                header('Content-type: image/*');
                $archivo = './media/' . $id;
                readfile($archivo);
                exit();
            }else{
                $this->index();
            }
        }else{
            $this->index();
        }
    }
    
    function renderPost($posts){
        $html1 = '<div class="post">
            <div class="profile">
            <div><img src="perfil/viewPhotoOtherProfiles?id={{idPerfil}}"/></div>
            <div><a href="perfil/profileTemplate?id=id={{idPerfil}}"><p>{{name}} {{surname}}</p></a></div>
            <div><p>{{fecha}}</p></div>
            </div>
            <div class="content"><p>{{texto}}</p>
            <img src="post/viewImagePost?id={{id}}"/></div>
            <div class="likeCount"> A {{likes}} Personas les gusta esto</div>
            <div id="commentsPlace">{{comments}}</div>
            <div class="footerPost"><div><a href="#" class="like" data-id="{{id}}"><i class="far fa-heart"></i> Like</a></div>
            <div><a href="#" class="comment"><i class="far fa-comments"></i> Comentar</a></div></div>
            <div class="comentInput oculto">
            <form class="commentForm"><textarea placeholder="Comentar" class="texto"></textarea>
            <input type="submit" value="Comentar" /><input class="id" type="hidden" value="{{id}}"/></form>
            </div>
            </div>';
        $html2 = '<div class="post">
            <div class="profile">
            <div><img src="perfil/viewPhotoOtherProfiles?id={{idPerfil}}"/></div>
            <div><a href="perfil/profileTemplate?id={{idPerfil}}"><p>{{name}} {{surname}}</p></a></div>
            <div><p>{{fecha}}</p></div>
            </div>
            <div class="content"><p>{{texto}}</p></div>
            <div class="likeCount"> A {{likes}} Personas les gusta esto</div>
            <div id="commentsPlace">{{comments}}</div>
            <div class="footerPost"><div><a href="#" class="like" data-id="{{id}}"><i class="far fa-heart"></i> Like</a></div>
            <div><a href="#" class="comment"><i class="far fa-comments"></i> Comentar</a></div></div>
            <div class="comentInput oculto">
            <form class="commentForm"><textarea placeholder="Comentar" class="texto"></textarea>
            <input type="submit" value="Comentar" /><input class="id" type="hidden" value="{{id}}"/></form>
            </div>
            </div>';    
        $cadena  = '';
        
        foreach($posts as $post){
          if($post['media'] > '0'){
            $supp = $html1;
            $comments  = $this->renderComments($post['comentarios']);  
            $supp = str_replace('{{comments}}', $comments, $supp);
            $cadena .= Util::renderText($supp, $post);
          }else{
            $supp = $html2;
            $comments  = $this->renderComments($post['comentarios']);
            $text = str_replace('{{comments}}', $comments, $supp);
            $cadena .= Util::renderText($supp, $post);
          }
       }
       
       return $cadena;
    }
    
    function renderComments($comentarios){
        $html = '';
        foreach($comentarios as $comentario){
            $html .= '<div class="comentario">
            <div><img src="perfil/viewPhotoOtherProfiles?id={{idUser}}"/><p>{{name}} {{surname}}</p></div>
            <div><p class="cuerpo">{{texto}}<p></div><hr>
            </div>';
        }
        return $html;
    }
}