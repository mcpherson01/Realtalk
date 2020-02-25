<?php 
class NJT_APP_LIKE_COMMENT_API
{
  private $APP_ID;
  private  $sercet;
  private $ver = 'v2.12';
  function __construct()
  {
    $this->APP_ID=get_option('njt_app_like_comment_app_id');
    $this->sercet=get_option('njt_app_like_comment_app_id_serect');
  }
    // Connect Facebook
  public function connet(){
    try{
      $fb = new Facebook\Facebook([
        'app_id' => $this->APP_ID,
        'app_secret' => $this->sercet,
        'default_graph_version' => $this->ver,
        ]);
    }catch(Facebook\Exceptions\FacebookResponseException $e) {
      return $e;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      return $e;
    }
    return $fb ;
  }
    // CHECK TOKEN
  public function checkToken($token){
    $fb = $this->connet();
    try{
      $extoken = $fb->getOAuth2Client();
      $ex_token = $extoken->debugToken($token);
      return $ex_token;
    }catch(Facebook\Exceptions\FacebookResponseException $e){
      return $e->getMessage();
    }
    catch (Facebook\Exceptions\FacebookSDKException $e) {
      return $e->getMessage();
    }
  }
  // Get link Login FB
  public function GetLinkLogin($link_callback,$permissions=''){
    if(empty($link_callback)){
      return array('status'=>false,'msg'=>'Link Callback not found!');
    }
    $fb = $this->connet();
    $helper = $fb->getRedirectLoginHelper();
    if(empty($permissions)){
      $permissions = ['email'];
    }
    $loginUrl = $helper->getLoginUrl($link_callback, $permissions);
    return $loginUrl;
  }
  // Information admin page
  public function Me($token){
    $fb = $this->connet();
    try {
          // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name,accounts,picture{url}',$token);
      $user = $response->getGraphUser();
      return $user;
    } 
    catch(Facebook\Exceptions\FacebookResponseException $e) {
      //echo 'Graph returned an error: ' . $e->getMessage();
      //exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
     // echo 'Facebook SDK returned an error: ' . $e->getMessage();
     // exit;
    }
    
  }
  // Information admin page
  public function User_Subscribers($id_ser,$token){
    $fb = $this->connet();
    try {
          // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/id_ser?fields=id,name,picture{url}',$token);
      $user = $response->getGraphUser();
      return $user;
    } 
    catch(Facebook\Exceptions\FacebookResponseException $e) {
      //echo 'Graph returned an error: ' . $e->getMessage();
      //exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
     // echo 'Facebook SDK returned an error: ' . $e->getMessage();
     // exit;
    }
    
  }
  // Get Value Token
  public function get_Token($link_call_back){
    $fb = $this->connet();
    
    $helper = $fb->getRedirectLoginHelper();
    if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
    }
    try {
        $accessToken = $helper->getAccessToken($link_call_back);
        return $accessToken;
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        //return $e;
        return $e->getMessage();
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        //return $e;
        return $e->getMessage();
      }
  }
  // Get Value Token
  public function get_Token_check_error($link_callback){
    $fb = $this->connet();

    $helper = $fb->getRedirectLoginHelper();
    if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
    }
    try {
        $accessToken = $helper->getAccessToken($link_callback);
        return $accessToken;
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        wp_redirect($link_callback);
        exit();
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        wp_redirect($link_callback);
        exit();
      }
  }
  // Get Time Live Token (can : 2 Month , 3 month or forever)
  public function extoken($token){
    $fb = $this->connet();
    try{
      $extoken = $fb->getOAuth2Client();
      $ex_token = $extoken->getLongLivedAccessToken($token);
      return $ex_token->getValue();
    }catch(Facebook\Exceptions\FacebookResponseException $e){
      return $e->getMessage();
    }
    catch (Facebook\Exceptions\FacebookSDKException $e) {
      return $e->getMessage();
    }
  }

 
  //Check live time token (result return 1: live , 0 : die)
  public function check_token_live($token){
    $fb = $this->connet();
    try{
      $extoken = $fb->getOAuth2Client();
      $ex_token = $extoken->debugToken($token);
      return $ex_token->getIsValid();
    }catch(Facebook\Exceptions\FacebookResponseException $e){
      return $e->getMessage();
    }
    catch (Facebook\Exceptions\FacebookSDKException $e) {
      return $e->getMessage();
    }
  }
// Get Page
  public function Get_List_Page($token_full_permission){
    /*
        $fb = $this->connet();
        try {
                    $response = $fb->get('/me?fields=accounts.limit(9999){picture{url},name,id,access_token}',$token);   // only get picture, name, id , access_token
                  } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    return $e;
                  } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    return $e;
                  }
                  $user = $response->getGraphObject()->asArray();
                  return $user;
    */
        $graph_url = "https://graph.facebook.com/".$this->ver."/me?fields=accounts{id,name,picture}&access_token=".$token_full_permission;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);

        //$result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : json_decode($result,true));
  }
  // GET ID PAGE WITH NAME
  public function Get_ID_Page($token,$name){
    $fb = $this->connet();
      try {
            // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get("/$name?fields=id",$token);
      } 
      catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
      $object = $response->getGraphObject();
      return $object['id'];  
  }
  // Get List Post  (Check user like and user comment)

  public function Get_UserLike_UserComment_Posts($token,$id_post){
        /*
              $fb = $this->connet();
              try{
                //$page=$this->Me($token)['accounts'];
                $response = $fb->get("/$id_post?fields=likes.limit(999999){id},comments.limit(999999){from,id,message}",$token);
              }catch(Facebook\Exceptions\FacebookResponseException $e){
                //return $e->getMessage();
                wp_redirect($link_callback);
              }
              catch (Facebook\Exceptions\FacebookSDKException $e) {
                //return $e->getMessage();
                wp_redirect($link_callback);
              }
              $list_infor = $response->getGraphObject()->asArray();
              return $list_infor;
        */
      $url = sprintf('https://graph.facebook.com/%1$s/%2$s?fields=reactions.limit(999999){id,name,type},comments.limit(999999){from,id,message}&access_token=%3$s', $this->ver,$id_post, $token);
      
      $posts = $this->cURL($url);
      return json_decode($posts);
  }

  public function Get_UserLike_UserComment_Posts_Fanpage($page_access_token,$id_post){
      /*
              $fb = $this->connet();
              try{
                //$page=$this->Me($token)['accounts'];
                $response = $fb->get("/$id_post?fields=likes.limit(999999){id},comments.limit(999999){from,id,message}",$page_access_token);
              }catch(Facebook\Exceptions\FacebookResponseException $e){
                //return $e->getMessage();
                wp_redirect($link_callback);
              }
              catch (Facebook\Exceptions\FacebookSDKException $e) {
                //return $e->getMessage();
                wp_redirect($link_callback);
              }
              $list_infor = $response->getGraphObject()->asArray();
              return $list_infor;
      */
      $url = sprintf('https://graph.facebook.com/%1$s/%2$s?fields=reactions.limit(999999){id,name,type},comments.limit(999999){from,id,message}&access_token=%3$s', $this->ver,$id_post, $page_access_token);
      
      $posts = $this->cURL($url);
      return json_decode($posts);
  }
// List Post (Page)
  public function NJT_List_Post($token,$id_page){
      $fb = $this->connet();
      try{
          //$page=$this->Me($token)['accounts'];
          $response = $fb->get("/$id_page?fields=posts.limit(9999){id,message,permalink_url}",$token);
          }catch(Facebook\Exceptions\FacebookResponseException $e){
                return $e->getMessage();
          }
          catch (Facebook\Exceptions\FacebookSDKException $e) {
                return $e->getMessage();
          }
      $list_post = $response->getGraphObject()->asArray();
      return $list_post;
  }

// Get List user like
  public function NJT_List_User_Like($token,$id_post){
    $fb = $this->connet();
      try{
            //$page=$this->Me($token)['accounts'];
            $response = $fb->get("/$id_post?fields=likes{id,name,username,picture{url},link}",$token);
            }catch(Facebook\Exceptions\FacebookResponseException $e){
              return $e->getMessage();
            }
              catch (Facebook\Exceptions\FacebookSDKException $e) {
              return $e->getMessage();
          }

      $list_post = $response->getGraphObject()->asArray();
      return $list_post;
  }

// Get Comment

  public function NJT_List_Comments($token,$id_post){
      $fb = $this->connet();
      try{
            $response = $fb->get("/$id_post?fields=comments",$token);
            }catch(Facebook\Exceptions\FacebookResponseException $e){
              return $e->getMessage();
            }
            catch (Facebook\Exceptions\FacebookSDKException $e) {
              return $e->getMessage();
          }
            $list_comment = $response->getGraphUser();
            return $list_comment;
  }

// Get Fetch
  
  public function NJT_fetchMeta_1($link,$token){
          $fb = $this->connet();
          try{
            $metaf = $fb->get($link,$token);
            $decoded_permissions = $metaf->getDecodedBody();
            return $decoded_permissions;
          } catch (Facebook\Exceptions\FacebookResponseException $e) {
          return $e->getMessage();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
          return $e->getMessage();
        }
  }


  public function NJT_fetchMeta_2($link,$token){
          $fb = $this->connet();
          try{
            $data = array(
              'scrape'=>true,
              'id'=>$link
            );
            $metaf = $fb->post('/',$data,$token);
            $decoded_permissions = $metaf->getDecodedBody();
            return $decoded_permissions;
          } catch (Facebook\Exceptions\FacebookResponseException $e) {
          return $e->getMessage();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
          return $e->getMessage();
        }
      }



  
 
// auto post
// Get access Token Page
  public function Get_Access_Token_Page($token_full,$id_page){
    /*  
          $fb = $this->connet();
          try {
            $response = $fb->get("/$id_page?fields=access_token",$token); 
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e;
          }
          $access_token = $response->getGraphObject()->asArray();
          return $access_token;
    */
        $graph_url = "https://graph.facebook.com/".$this->ver."/".$id_page."?fields=access_token&access_token=".$token_full;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);

        //$result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : json_decode($result,true)["access_token"]);
  }
// Auto Post Facebook TO PAGE

  public function Publish_post_in_page($message,$linkUrl,$token_full,$id_page){
        $token_page = $this->Get_Access_Token_Page($token_full,$id_page);
        $url = "https://graph.facebook.com/".$this->ver."/".$id_page."/feed";
        $post = 'access_token=' . $token_page . '&message=' . $message .'&link='.$linkUrl;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);
        return json_decode($str,true);
  }
      // AuTo Edit Post FaceBook
  public function Edit_Post($message,$linkUrl,$token_full,$id_post)
  {
    /*
          $fb=$this->connet();
          $linkData = [
          'message' => $message,
          'link' => $linkUrl,
          ];
          // post to Facebook
          try {
              // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post("/$id_post", $linkData,$access_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
          //  echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
          //  echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }
          $graphNode = $response->getGraphNode();
          return $graphNode;
    */
        $url = "https://graph.facebook.com/".$this->ver."/".$id_post;
        $post = 'access_token=' . $token_full . '&message=' . $message .'&link='.$linkUrl;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);
        return json_decode($str,true);
  }

// AUTO POST FACEBOOK TO TIMELINE
  public function Publish_post_to_Timeline($message,$linkUrl,$token_full){
      /*  
          $fb=$this->connet();
          $linkData = [
          'message' => $message,
          'link' => $linkUrl,
          ];
          // post to Facebook
          try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post("/me/feed", $linkData, $access_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
           // echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
          //  echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }
          $graphNode = $response->getGraphNode();
          return $graphNode['id'];
      */
        $url = "https://graph.facebook.com/".$this->ver."/me/feed";
        $post = 'access_token=' . $token_full . '&message=' . $message .'&link='.$linkUrl;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $str = curl_exec($ch);
        curl_close($ch);
        return json_decode($str,true);
  }
// AuTo Edit Post FaceBook To Timeline
// content auto post
  public function getContent($url) {
          $ci = curl_init();
          /* Curl settings */
          curl_setopt($ci, CURLOPT_URL, $url);
          curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ci, CURLOPT_HEADER, false);
          curl_setopt( $ci, CURLOPT_CONNECTTIMEOUT, 10 );
          curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
          $response = curl_exec($ci);
          curl_close ($ci);
          return $response;
        }
 
// GET LIST USER SUBSCRIBER

  public function user_data($token){

        $fb = $this->connet();

        try {

            $permissions_query = $fb->get( '/me?fields=id,name,gender,email,locale,picture,first_name,last_name', $token );

            $decoded_permissions = $permissions_query->getDecodedBody();

            return $decoded_permissions;

          } catch (Facebook\Exceptions\FacebookResponseException $e) {

            return $e->getMessage();



          } catch (Facebook\Exceptions\FacebookSDKException $e) {



            return $e->getMessage();



          }


  }

// GET INFO USER SUBSCRIBER
  public function GET_INFO_USER_SUB_FULL_PER($token_full,$id_user){
    $graph_url = "https://graph.facebook.com/".$this->ver."/".$id_user."?fields=id,name,gender,email,locale,picture,first_name,last_name&access_token=".$token_full;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);

        //$result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : json_decode($result,true));
  }
// =================
  public function SpiderLink_Group_Icon_To_GroupID($group_id,$token){
    /*
      $fb = $this->connet();
      try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get("/$group_id?fields=icon",$token);
            $data_group = $response->getGraphObject()->asArray();
            return $data_group['icon'];
          } 
          catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            //exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
           // exit;
          }
    */
        $graph_url = "https://graph.facebook.com/".$this->ver."/".$group_id."?fields=icon&access_token=".$token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);

        //$result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : json_decode($result,true));
  }

  //============== GET Name Group To Group ID===================
  public function SpiderLink_Group_Name($group_id,$token){
    /*
      $fb = $this->connet();
      try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get("/$group_id?fields=id,name,privacy",$token);
            $data_group = $response->getGraphObject()->asArray();
            return $data_group;
          } 
          catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            //exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
           // exit;
          }
    */
        $graph_url = "https://graph.facebook.com/".$this->ver."/".$group_id."?fields=id,name,privacy&access_token=".$token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);

        //$result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : json_decode($result,true));
  }

  public function SpiderLink_Group_ID_Name_Search($name,$token){
    /*
      $fb = $this->connet();
      try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get("/search?q=$name&type=group",$token);
            $data_group = $response->getDecodedBody();
            return $data_group['data'][0]; // get group first
          } 
          catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            //exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
           // exit;
          }
      */
        $graph_url = "https://graph.facebook.com/".$this->ver."/search?type=group&q=".$name."&access_token=".$token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        return ((isset($result->error)) ? $result->error->message : $result->data[0]);
  }
  public function cURL($url){
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        curl_close($ch);
        
        return $return;
  }
  public function Spider_GET_ALL_Group_Page_Post($group_page_id,$token){
    /*
      $fb = $this->connet();
      try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get("/$group_page_id?fields=feed.limit(30){message,id}",$token);
            $data_group = $response->getDecodedBody();
            return $data_group; // get group first
          } 
          catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            //exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
           // exit;
          }
    */
        $url = sprintf('https://graph.facebook.com/%1$s/%2$s/feed?fields=message,id&limit=30&access_token=%3$s', $this->ver, $group_page_id, $token);
        //exit($url);
        //likes,comments,is_published
        $posts = $this->cURL($url);
        return json_decode($posts);
       
  }

  public function Get_UserLike_UserComment_Posts_Group($token,$id_post){
      
      $url = sprintf('https://graph.facebook.com/%1$s/%2$s?fields=reactions.limit(999999){id,name,type},comments.limit(999999){from,id,message}&access_token=%3$s', $this->ver,$id_post, $token);
      
      $posts = $this->cURL($url);
      return json_decode($posts);   
  }

}
?>