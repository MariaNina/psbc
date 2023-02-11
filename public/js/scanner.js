$(function(){
let page_route ="/scan";
let fullname = "";
let se = "";
let dep = "";
let lrn ="";
let imgA = "";

$("#infobar").focus();
document.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        
       const datas = document.getElementById("infobar").value.split(",",6);
        console.log(datas);
        if(datas.length<2)
      {
        alert("Invalid QR Code");
      }else{
      fullname.innerHTML = datas[2];
      dep.innerHTML = datas[5];
      if(datas[3]=="employee"){
        se.innerHTML ="Employee No.:<span id='lrn'>"+datas[0]+"</span>";
      }
      if(datas[3]=="student"){
        se.innerHTML ="LRN:<span id='lrn'>"+datas[0]+"</span>";
      }
      if(datas[1]=="null" || datas[1]==null)
      {
        imgA.src="https://st.depositphotos.com/2101611/3925/v/600/depositphotos_39258143-stock-illustration-businessman-avatar-profile-picture.jpg";
      }
      else{
        imgA.src="storage"+datas[1];
      }
      
      $.ajax({
        url: page_route,
        type: "POST",
        data:{
          student_name:datas[2],
          lrn:datas[0],
          department:datas[5],
          _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data){
          alertSuccess('Logged') //calls function alertSuccess in public\js\main.js
          $("#infobar").val("");
        $("#infobar").focus();
      },
      error: function (xhr, status, errorThrown) {
          alertFailed('Log')  //calls function alertFailed in public\js\main.js
          $("#infobar").val("");
        $("#infobar").focus();
      }
    })
  }
        $("#infobar").val("");
        $("#infobar").focus();
    }
});
// let opts = {
//   // Whether to scan continuously for QR codes. If false, use scanner.scan() to manually scan.
//   // If true, the scanner emits the "scan" event when a QR code is scanned. Default true.
//   continuous: true,
  
//   // The HTML element to use for the camera's video preview. Must be a <video> element.
//   // When the camera is active, this element will have the "active" CSS class, otherwise,
//   // it will have the "inactive" class. By default, an invisible element will be created to
//   // host the video.
//   video: document.getElementById('preview'),
  
//   // Whether to horizontally mirror the video preview. This is helpful when trying to
//   // scan a QR code with a user-facing camera. Default true.
//   mirror: true,
  
//   // Whether to include the scanned image data as part of the scan result. See the "scan" event
//   // for image format details. Default false.
//   captureImage: true,
  
//   // Only applies to continuous mode. Whether to actively scan when the tab is not active.
//   // When false, this reduces CPU usage when the tab is not active. Default true.
//   backgroundScan: true,
  
//   // Only applies to continuous mode. The period, in milliseconds, before the same QR code
//   // will be recognized in succession. Default 5000 (5 seconds).
//   refractoryPeriod: 5000,
  
//   // Only applies to continuous mode. The period, in rendered frames, between scans. A lower scan period
//   // increases CPU usage but makes scan response faster. Default 1 (i.e. analyze every frame).
//   scanPeriod: 1
// };
// let scanner = new Instascan.Scanner(opts);
// This method will trigger user permissions
 fullname = document.getElementById("fname");
se = document.getElementById("se");
dep = document.getElementById("dep");
lrn = document.getElementById("lrn");
imgA = document.getElementById("avatar");
Html5Qrcode.getCameras().then(devices => {
  /**
   * devices would be an array of objects of type:
   * { id: "id", label: "label" }
   */
  if (devices && devices.length) {
    let cameraId = devices[0].id;
   
    const html5QrCode = new Html5Qrcode("reader");
setInterval(()=>{
html5QrCode.start(
  cameraId,     // retreived in the previous step.
  {
    fps: 15,    // sets the framerate to 10 frame per second
    //qrbox: 250  // sets only 250 X 250 region of viewfinder to
                // scannable, rest shaded.
  },
  content => {
    html5QrCode.stop();
    // do something when code is read. For example:
    const datas = content.split(",",6);
    console.log(datas);
    if(datas.length<2)
      {
        alert("Invalid QR Code");
      }else{
      fullname.innerHTML = datas[2];
      dep.innerHTML = datas[5];
      if(datas[3]=="employee"){
        se.innerHTML ="Employee No.:<span id='lrn'>"+datas[0]+"</span>";
      }
      if(datas[3]=="student"){
        se.innerHTML ="LRN:<span id='lrn'>"+datas[0]+"</span>";
      }
      if(datas[1]=="null" || datas[1]==null)
      {
        imgA.src="https://st.depositphotos.com/2101611/3925/v/600/depositphotos_39258143-stock-illustration-businessman-avatar-profile-picture.jpg";
      }
      else{
        imgA.src="storage"+datas[1];
      }
      
      $.ajax({
        url: page_route,
        type: "POST",
        data:{
          student_name:datas[2],
          lrn:datas[0],
          department:datas[5],
          _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data){
          alertSuccess('Logged') //calls function alertSuccess in public\js\main.js
          html5QrCode.start();
          $("#infobar").val("");
        $("#infobar").focus();
      },
      error: function (xhr, status, errorThrown) {
          alertFailed('Log')  //calls function alertFailed in public\js\main.js
          $("#infobar").val("");
        $("#infobar").focus();
      }
    })
  }},
  errorMessage => {
    // parse error, ideally ignore it. For example:
    
  })},5000)
.catch(err => {
  // Start failed, handle it. For example,
  console.log(`Unable to start scanning, error: ${err}`);
});
  }
}).catch(err => {
  // handle err
});




//     scanner.addListener('scan', function (content) {
//       //console.log(content);
//       //imgA.src = "storage"+content;
      
//       const datas = content.split(",",6);
//       console.log(datas);
//       if(datas.length<2)
//       {
//         alert("Invalid QR Code");
//       }else{
//       fullname.innerHTML = datas[2];
//       dep.innerHTML = datas[5];
//       if(datas[3]=="employee"){
//         se.innerHTML ="Employee No.:<span id='lrn'>"+datas[0]+"</span>";
//       }
//       if(datas[3]=="student"){
//         se.innerHTML ="LRN:<span id='lrn'>"+datas[0]+"</span>";
//       }
//       if(datas[1]=="null" || datas[1]==null)
//       {
//         imgA.src="https://st.depositphotos.com/2101611/3925/v/600/depositphotos_39258143-stock-illustration-businessman-avatar-profile-picture.jpg";
//       }
//       else{
//         imgA.src="storage"+datas[1];
//       }
//       $.ajax({
//         url: page_route,
//         type: "POST",
//         data:{
//           student_name:datas[2],
//           lrn:datas[0],
//           department:datas[5],
//           status:1,
//           _token:$('meta[name="csrf-token"]').attr('content'),
//         },
//         success: function(data){
//           alertSuccess('Logged') //calls function alertSuccess in public\js\main.js
//       },
//       error: function (xhr, status, errorThrown) {
//           alertFailed('Log')  //calls function alertFailed in public\js\main.js
//       }
//     })

//     }
//       console.log(datas);
//     });
//     Instascan.Camera.getCameras().then(function (cameras) {
//       if (cameras.length > 0) {
//         scanner.start(cameras[0]);
//       } else {
//         console.error('No cameras found.');
//       }
//     }).catch(function (e) {
//       console.error(e);
//     });
 });