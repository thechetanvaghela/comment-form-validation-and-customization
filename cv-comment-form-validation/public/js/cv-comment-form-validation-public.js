document.addEventListener('DOMContentLoaded', function(){ 
    if(document.querySelector(".comment-form")){
        document.querySelector(".comment-form").addEventListener("submit", function(e){            
            var requiredElements = document.getElementById("commentform").querySelectorAll("[required]");
            if(requiredElements){
                for (var i = 0; i < requiredElements.length; i++){
                    var ele = requiredElements[i];
                    var pDoc = document.getElementById(ele.id);
                    parentDiv = pDoc.parentNode;
                    if(parentDiv){    
                        var parentDiv_children = parentDiv.querySelectorAll('.cfv-form-error');
                        if(parentDiv_children.length){
                            parentDiv_children.forEach(e => e.remove());
                        }
                        if(ele.value == ''){
                            parentDiv.innerHTML = parentDiv.innerHTML + '<span class="cfv-form-error">Please enter value.<span>';
                            e.preventDefault();
                        }else{
                            if(ele.type == 'email'){
                                if(!CFVvalidateEmail(ele.value)){
                                    parentDiv.innerHTML = parentDiv.innerHTML + '<span class="cfv-form-error">Please enter valid email address.<span>';
                                    e.preventDefault();
                                }
                            }
                        }
                    }
                }
            }
        });
    }
    function CFVvalidateEmail(email){
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }	
}, false);