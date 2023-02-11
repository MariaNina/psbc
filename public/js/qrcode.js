$(function() {
    let id;
    let page_route ="/students";
    let page_base ="/employees";
    //qrcode clicked
    $('body').on('click', '.qrcode-data', function(e) {
       
           
                id = $(this).data('id');
                console.log(id)
                $.ajax({
                    url: page_route+"/"+id,
                    type: "GET",
                }).done((result)=>{
                    console.log(result);
                    // let img =JSON.parse(result);
                    let arr =result.lrn.lrn+","+result.img.image+","+result.name.name+",student,"+result.parent_contact.contact_number+","+result.department.student_department;
                    let qrcode = new QRCode(document.getElementById("qrcode"), {
                        text: "Scan Me",
                        width: 300,
                        height: 300,
                        colorDark : "#000000",
                        colorLight : "#FFFFFF",
                        correctLevel : QRCode.CorrectLevel.H,
                    });
                    qrcode.makeCode(arr);
                    console.log(arr);
                    $('#qrCodeModal').modal('show');
                    //clear qrcode
                    $(".close").on("click", function(){
                        console.log("1");
                        $("#qrcode").html("");
                     });
                })
                

                
    });

    $('body').on('click', '.qrcode-employee', function(e) {
       
        let arr = null; 
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: page_base+"/"+id,
            type: "GET",
        }).done((result)=>{
            // let img =JSON.parse(result);
            console.log(result);
            arr =result.lrn.csc_id+","+result.img.image+","+result.name.name+",employee,"+null+","+result.department.Department;
            let qrcode = new QRCode(document.getElementById("qrcode"), {
                text: "Scan Me",
                width: 300,
                height: 300,
                colorDark : "#000000",
                colorLight : "#FFFFFF",
            });
            qrcode.makeCode(arr);
            console.log(arr);
            $('#qrCodeModal').modal('show');
            //clear qrcode
            $(".close").on("click", function(){
                console.log("1");
                $("#qrcode").html("");
             });
        })
        

        
});
    

});
