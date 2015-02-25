<!Doctype html>
<html> 
    <head> 
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
        <script type="text/javascript" src="js/jquery.facebook.multifriend.select.js"></script> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>multifriend.select</title>
        <link rel="stylesheet" href="css/jquery.facebook.multifriend.select.css" /> 
        <style> 
            body {
                background: #fff;
                color: #333;
                font: 11px verdana, arial, helvetica, sans-serif;
            }
            a:link, a:visited, a:hover {
                color: #666;
                font-weight: bold;
                text-decoration: none;
            }
        </style> 
    </head> 
    <body> 
 
        <div id="pageBody"> 
            <div id="fb-root"></div> 
            <script src="http://connect.facebook.net/zh_TW/all.js"></script> 
            <script> 
				window.fbAsyncInit = function(){
					FB.init({
						appId : '311469932366785',
						status: true, 	// check login status
						cookie: true, 	// enable cookies to allow the server to access the session
						oauth: true, 	// enable OAuth 2.0
						xfbml: true,  	// parse XFBML
						version: 'v2.2'	// version
					});
					
					FB.getLoginStatus(function (response) {
						is_init = true;
					
						if (response.status === 'connected') {
							//login success
							init();
						} else if (response.status === 'not_authorized') {
							//not_authorized
						} else {
							//not connect
						}
					});
				}; 
 
                function login() {
                    FB.login(function(response) {
						console.log(response);
                        if (response.authResponse) {
							FB.api('/me', function(response) {
								init();
							});
                        } else {
                            alert('Login Failed!');
                        }
                    }, {scope: 'user_likes,email,public_profile,user_friends'});
                }
 
                function init() {
                  FB.api('/me', function(response) {
                      $("#username").html("<img src='https://graph.facebook.com/" + response.id + "/picture'/><div>" + response.name + "</div>");
					
                      $("#jfmfs-container").jfmfs({
						/* english */
						
					      max_selected: 15, 
						  max_selected_message: "{0} of {1} selected",
						  friend_fields: "id,name,last_name",
						  pre_selected_friends: [1014025367],
						  exclude_friends: [1211122344, 610526078],
						  sorter: function(a, b) {
			                var x = a.last_name.toLowerCase();
			                var y = b.last_name.toLowerCase();
			                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
						  }
						 
						 
						/* chinese */
						/*
						 labels: {
                            title: '請選擇要一起挑戰的虎伴',
                            selected: "只顯示已選",
                            filter_default: "",
                            filter_title: "找朋友",
                            all: "顯示全部",
                            max_selected_message: "已選 {0} / {1}",
                            close: "不選",
                            cancel: '取消'
                          },
                          max_selected: 1
						 */
			          });
                      $("#jfmfs-container").bind("jfmfs.friendload.finished", function() { 
                          window.console && console.log("finished loading!"); 
                      });
                      $("#jfmfs-container").bind("jfmfs.selection.changed", function(e, data) { 
                          window.console && console.log("changed", data);
                      });                     
                      
                      $("#logged-out-status").hide();
                      $("#show-friends").show();
  
                  });
                }              
 
                
 
                $("#show-friends").live("click", function() {
                    var friendSelector = $("#jfmfs-container").data('jfmfs');             
                    $("#selected-friends").html(friendSelector.getSelectedIds().join(', ')); 
                });                  
 
 
              </script> 
              
              <div id="logged-out-status" style=""> 
                  <a href="javascript:login()">Login</a> 
              </div> 
 
              <div> 
                  <div id="username"></div> 
                  <a href="#" id="show-friends" style="display:none;">Show Selected Friends</a> 
                  <div id="selected-friends" style="height:30px"></div> 
                  <div id="jfmfs-container"></div> 
              </div> 
        </div> 
    </body> 
</html> 