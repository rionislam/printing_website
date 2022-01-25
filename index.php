<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="style.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script>
      let bSize = 'A4 (29.7cm x 21cm / 297mm x 210mm)';
      let iColor = 'Black & White Standard';
      let pType = '60 Cream paper';
      let bType = 'Paperback';
      let cFinish = 'Glossy';
      let fPages = '';
      let bSizeValue = 'a4';
      let iColorValue = '0.8';
      let pTypeValue = '1.6';
      let bTypeValue = '90';
      let value1 = '';
      let value2 = parseFloat(iColorValue)+parseFloat(bTypeValue);
      let finalValue = '';
      let sWidth = '';
      let cWidth = '12.09';
      let cHeight = '8.52';

      

      const change = function(file){
         fileName = file.files[0].name;
         fileSize = file.files[0].size / 1000000;
         fileType = file.files[0].type.split('/')[1];

         let reader = new FileReader();
         reader.readAsBinaryString(file.files[0]);
         reader.onloadend = function(){
            let filePages = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
            document.getElementById('filePages').innerHTML = filePages;
            document.getElementById('pagecount').value = filePages;
            document.getElementById('pageCount').innerHTML = filePages;
            fPages = filePages;
            value1 = parseFloat(fPages)*parseFloat(pTypeValue);
            finalValue = parseFloat(value1)+parseFloat(value2);
            document.getElementById('price').innerHTML = finalValue;
            sWidth = parseFloat(fPages)*0.002252;
            sWidth = sWidth.toFixed(2);
            document.getElementById('spineWidth').innerHTML = sWidth;
         }

         document.getElementById('fileName').innerHTML = fileName;
         document.getElementById('fileSize').innerHTML = fileSize + ' mb';
         document.getElementById('fileType').innerHTML = fileType;
         document.getElementById('loading').style.display = 'block';
               setTimeout(function(){
                  document.getElementById('loading').style.display = 'none';
                  document.getElementById('load').style.display = 'flex';
               }, 2000);
      }
      const bookSize = function(e){
         text = e.selectedOptions[0].text;
         value = e.selectedOptions[0].value;
         document.getElementById('bookSize').innerHTML = text;
         document.getElementById('fBookSize').innerHTML = text.split('(')[1].split(')')[0];
         bSize = text;
         bSizeValue = value;
         bWidth = value.split('x')[0];
         bHeight = value.split('x')[1];
         cWidth = 0.125+parseFloat(bWidth)*0.39370+0.148632+0.125;
         cWidth = cWidth.toFixed(2);
         cHeight = 0.125+parseFloat(bHeight)*0.39370+0.125;
         cHeight = cHeight.toFixed(2);
         document.getElementById('cWidth').innerHTML = cWidth;
         document.getElementById('cHeight').innerHTML = cHeight;
      }

      const interiorColor = function(e){
         text = e.selectedOptions[0].text;
         value = e.selectedOptions[0].value;
         document.getElementById('interiorColor').innerHTML = text;
         iColor = text;
         iColorValue = value;
         value2 = parseFloat(bTypeValue)+parseFloat(iColorValue);
         finalValue = parseFloat(value1)+parseFloat(value2);
         document.getElementById('price').innerHTML = finalValue;
         if(value == 3.50 || value == 3.20 ){
            document.getElementById('pTypeOptional').style.display = 'none';
            document.getElementById('papertype').value = '1.75';
            pTypeValue = '1.75';
         }else{
            document.getElementById('pTypeOptional').style.display = 'block';
            document.getElementById('papertype').value = '1.6';
            pTypeValue = '1.6';
         }

      }

      const paperType = function(e){
         text = e.selectedOptions[0].text;
         value = e.selectedOptions[0].value;
         document.getElementById('paperType').innerHTML = text;
         pType = text;
         pTypeValue = value;
         value1 = parseFloat(fPages)*parseFloat(pTypeValue);
         finalValue = parseFloat(value1)+parseFloat(value2);
         document.getElementById('price').innerHTML = finalValue;
      }

      const bindingType = function(e){
         text = e.selectedOptions[0].text;
         value = e.selectedOptions[0].value;
         document.getElementById('bindingType').innerHTML = text;
         bType = text;
         bTypeValue = value;
         value2 = parseFloat(bTypeValue)+parseFloat(iColorValue);
         finalValue = parseFloat(value1)+parseFloat(value2);
         document.getElementById('price').innerHTML = finalValue;
         
      }
      
      const coverFinish = function(e){
         text = e.selectedOptions[0].text;
         document.getElementById('coverFinish').innerHTML = text;
         cFinish = text;  
      }

      const pageCount = function(e){
         text = e.value;
         document.getElementById('pageCount').innerHTML = text;
         fPages = text;
         value1 = parseFloat(fPages)*parseFloat(pTypeValue);
         finalValue = parseFloat(value1)+parseFloat(value2);
         document.getElementById('price').innerHTML = finalValue;
         sWidth = parseFloat(fPages)*0.002252;
         sWidth = sWidth.toFixed(2);
         document.getElementById('spineWidth').innerHTML = sWidth;
      }

      document.addEventListener('DOMContentLoaded', ()=>{
         document.getElementById('print_online_form').addEventListener('submit', function(e) {
               e.preventDefault();
               var formData = new FormData(this);
               formData.append('file', $('#fileToUpload').prop('files')[0]);
               formData.append('submit', $('form-button').val());
               formData.append('bookPage', bSize);
               formData.append('interiorColor', iColor);
               formData.append('paperType', pType);
               formData.append('bindingType', bType);
               formData.append('coverFinish', cFinish);
               formData.append('pages', fPages);
               formData.append('finalValue', finalValue);
               formData.append('cWidth', cWidth);
               formData.append('cHeight', cHeight);
               formData.append('totalValue', parseFloat(finalValue)+200);
               formData.append('sWidth', sWidth);
               $.ajax({
                  url: "placeorder.php",
                  type: "POST",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(data) {
                    $('#fileToUpload').val("");
                    $('#alert').show();
                    $('#alert').html(data);
                    window.location.replace("thankYou.php");
                  }

               })
               
               
      })
   })



   </script>

</head>
<body>
   
<div class="box simple_contact">
   <form id="print_online_form" name="print_online_form" method="post" enctype="multipart/form-data">
      <fieldset class="group-select">
         
         <h1 class="a">Print your PDF Online</h1>
         <h2 class="b">Upload your PDF to get started</h2>
         <p class="c">Hardcover or paperback book using a wide range of paper, color, and binding options.<br> The most common print-on-demand book, perfect for a variety of projects.</p>
         <label class="Custom-File-Upload">
         <input type="file" name="fileToUpload" id="fileToUpload" onchange="change(this)" required>
         <i class="fa fa-cloud-upload"></i> Upload PDF</label>
         <p id="filename"></p>
         
         <br>
         <ul>
            <li>Sent file: <div id="fileName"></div></li>
            <li>File size: <div id="fileSize"></div></li>
            <li>File type: <div id="fileType"></div></li>
            <li>File Pages: <div id="filePages"></div></li>
         </ul>
         <br>
         <!--BOOK SIZE AND PAGE GOES HERE-->
         <div class="wraper f">
            <h2>Book Size and Page Count</h2>
            <p>Select a Book Size and Page Count for your Book.</p>
         </div>
         <div class="wraper1">
            <div class="left">
               <label for="bookpage">Book Size</label><br>
               <select name="bookpage" id="bookpage" onchange="bookSize(this)">
               <option value="29.7x21">A4 (29.7cm x 21cm / 297mm x 210mm)</option>
               <option value="21x14.8">A5 (21cm x 14.8cm / 210mm x 148mm)</option>
               <option value="19x25">B5 (19cm x 25cm / 190mm x 250mm)</option>
               <option value="20.3x12.7">Novel (20.3cm x 12.7cm / 203mm x 127mm)</option>
               <option value="4.25x6.87">Fiction (4.25 x 6.87, 5 x 8, 5.25 x 8, 5.5 x 8.5, 6 x 9)</option>
               <option value="7.5x7.5">Children’s (7.5 x 7.5, 7 x 10, 10 x 8)</option>
               <option value="5.5x8.5">Non-fiction (5.5 x 8.5, 6 x 9, 7 x 10")</option>
               <option value="5.25x8">Memoir (5.25 x 8, 5.5 x 8.5)</option>
               <option value="5.25x8">US Royal (22.9cm x 15.2cm / 229mm x 152mm)</option>
               <option value="5.25x8">Royal (23.4cm x 15.6cm / 234mm x 156mm)</option>
               <option value="5.25x8">Square (21cm) (210mm)</option>
               <option value="5.25x8">Standard (19.7cm x 13.2cm / 197mm x 132mm)</option> 
               </select>
            </div>
            <div class="righ">
               <label for="pagecount">Page Count</label><br>
               <input type="number" id="pagecount" name="pagecount" placeholder="" min="1" max="100" onchange="pageCount(this)" required>
            </div>
         </div>
        <br></br>
        <!--Interior Color-->
        <div class="wraper g">
           <h2>Interior Color</h2>
           <p>Standard ink is recommended for Books using text and limited graphics, <br>while Premium is ideal for rich colors and more complex graphics.</p>
        </div>
        <div class="wraper2">
         <label for="interiorcolor">Interior Color</label><br>
         <select name="interiocolor" id="interiocolor" onchange="interiorColor(this)">
         <option value="0.8">Black & White Premium</option> 
         <option value="0.5">Black & White Standard</option> 
         <option value="3.50">Color Premium</option>
         <option value="3.20">Color Standard</option>
         </select>
         </div>
        <!--Paper Type-->
        <div class="wraper h">
           <h2>Paper Type</h2>
           <p>For Premium ink, we suggest the heavier 80# paper.<br> For more economical options, use Standard ink and the 60# paper weight.</p>
        </div>
        <div class="wraper2">
         <label for="papertype">Paper Type</label><br>
         <select name="papertype" id="papertype" onchange="paperType(this)">
         <option id="pTypeOptional" value="1.6">60 - Cream paper</option>
         <option value="1.75">70 - Simple paper</option>
         <option value="1.9">80 - Matt Coated</option>
         </select>
        </div>
        <!--Binding Type-->
        <div class="wraper i">
           <h2>Binding Type</h2>
           <p>Select a binding type for your Book.</p>
        </div>
        <div class="wraper2">
         <label for="bindingtype">Binding Type</label><br>
         <select name="bindingtype" id="bindingtype" onchange="bindingType(this)">
         <option value="90">Paperback</option>
         <option value="200">Hardcover</option>
         <option value="85">Coil Bound</option>
         <option value="110">Saddle Stitch</option>
         <option value="70">Linen Wrap</option>
         </select>
        </div>
        <!--Cover Finish-->
        <div class="wraper j">
           <h2>Cover Finish</h2>
           <p>Select the cover finish for your Book.</p>
        </div>
        <div class="wraper2">
            <label for="coverfinish">Cover Finish</label><br>
            <select name="coverfinish" id="coverfinish" onchange="coverFinish(this)">
            <option value="gl">Glossy</option>
            <option value="mt">Matt</option>
            </select>
         </div>
         <!-- THIS DIV END FOR UPPER-->
        <div class="contact">
           <div class="left">
              <div class="top">
               <div class="input-box">
                  <label for="name">Give your name <span class="required">*</span></label><br />
                  <input name="name" id="name" title="Name" value="" class="required-entry input-text" type="text" required/>
               </div>
               <div class="input-box">
                  <label for="phone">Give your number <span class="required">*</span></label><br />
                  <input name="phone" id="phone" title="Phone" value="" class="required-entry input-inte" type="tel" required/>
               </div>
               </div>
            
            <div class="bottom">
               <div class="input-box">
                  <label for="email">And your email <span class="required">*</span></label><br />
                  <input name="email" id="email" title="Email" value="" class="required-entry input-text validate-email" type="email" required/>
               </div>
               <div class="input-box">
                  <label for="city">And your city <span class="required">*</span></label><br />
                  <input name="city" id="city" title="City" value="" class="required-entry input-text" type="text" required/>
               </div>
            </div>
            <div class="input-box">
                  <label for="city">And your address <span class="required">*</span></label><br />
                  <input name="address" id="address" title="address" value="" class="required-entry input-text" type="text" required/>
            </div>
         </div>
            <div class="right">
               <div class="input-box">
                  &nbsp;        <label for="comment">Some comment?</label><br />
                  <textarea name="comment" id="comment" title="Comment" class="required-entry input-text" style="height:100px;" cols="50" rows="3" required></textarea>
               </div>
            </div>
         </div>
      </fieldset>
      <div class="button-set">
         <p class="required">* Required Fields</p>
         <button class="form-button" type="submit" class="submit">Submit</button>
      </div>
   </form>
   <div id="loading">
      <img src="loading.gif">
   </div>
   <div id='load'>
      <div id="selections">
        <h2>Your Selection</h2>
        <ul>
            <li>Book Size:       <div id="bookSize">A4 (29.7cm x 21cm / 297mm x 210mm)</div></li>
            <li>Page Count:         <div id="pageCount">0</div></li>   
            <li>Interior Color:     <div id="interiorColor">Black & White Standard</div></li>
            <li>Binding Type:       <div id="bindingType">Paperback</div></li>   
            <li>Paper Type:         <div id="paperType">60 Cream paper</div></li>   
            <li>Cover Finish:       <div id="coverFinish">Glossy</div></li>   
         </ul>
      </div>
      <div id="requirements">
        <h2>Requirements</h2>
        <ul>
        <li>Page Size:     <div id="fBookSize">29.7cm x 21cm / 297mm x 210mm</div></li>
        <li>Cover Size:    <div id="coverSize"><span id="cWidth">12.09</span>in x <span id="cHeight">8.52</span>in</div></li> 
        <li>Spine Width:   <div id="spineWidth"></div>in</li> 
        <li>Cost per Book: Rs. <div id="price">0</div></li> 
        </ul>
        <a href="#">Download Invoice</a>
        
      </div>
   </div>
</div>
<div id="alert"></div>
</body>
</html>
