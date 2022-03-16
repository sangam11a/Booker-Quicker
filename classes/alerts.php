<!-- <style>
.card1{
z-index:999999;
position:relative;
width:50vw;
color:white;
border-radius: 10px;
display:grid;
grid-template-columns: 1fr;
margin-bottom:8vh;
box-shadow: 2px 4px 3px rgb(0,0,0,0.4);
}
.card1:hover{
    box-shadow: 4px 4px rgba(0,0,0,0.3);
}
.green{
    background-color:green;
}
.card1_head{
    margin-top:-2vh;
    padding:8px 12px;
    font-size:24px;
    font-weight:400;
}
.card1_body{
    padding:8px;
    padding-left:18px;
    font-weight:300px;
    font-size:22px;
    color:wheat;
}
.cross{
    z-index:999999;
    position:relative;
    left:45vw;
    top:2vh;
    font-size:30px;
    color:rgb(255,255,255,0.7);
}
.cross:hover{
    animation-duration: 2;
    font-size:36px;
    color:rgb(255,255,255,1.0);
    cursor: pointer;
}
</style> -->
<style>
.card1{
   
    margin-left:-15px;
    z-index: 999999;
    position: relative;
    width: 83vw;
    color: white;
    border-radius: 3px;
    display: grid;
    grid-template-columns: 1fr;
    margin-bottom: 8vh;
    box-shadow: 1px 1px 1px rgb(0 0 0 / 20%);
}
.card1:hover{
    box-shadow: 4px 4px rgba(0,0,0,0.3);
}
.green{
    background-color:green;
}
.card1_head{
    margin-top:-2vh;
    padding:8px 12px;
    font-size:24px;
    font-weight:400;
}
.card1_body{
    padding:8px;
    padding-left:18px;
    font-weight:300px;
    font-size:22px;
    color:wheat;
}
.cross{
    color:white;
    z-index:999999;
    position:relative;
    float:right;
    left:94%;
    top:2vh;
    font-size:30px;
    color:rgb(255,255,255,0.7);
}
.cross:hover{
    animation-duration: 2;
    font-size:36px;
    color:rgb(255,255,255,1.0);
    cursor: pointer;
}
</style>



<?php
 function small_alert($heading,$text=""){
                echo '<div class="card1 green">';
                    echo '<div class="cross" onclick="this.parentNode.style.display = \'none\'">&times;</div>';
                    echo '<div class="card1_head ">';
                       echo $heading;
                   echo ' </div>';
                   echo '<div class="card1_body">';
                        echo $text;;
                    echo '</div>';
               echo '</div>';
    }
   
    ?>
    