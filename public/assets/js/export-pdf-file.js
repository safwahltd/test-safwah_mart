function Export(tableID,filename = '') {

    // Specify file name
    filename = filename?filename+'.pdf':'pdf_data.pdf';
    // console.log(tableID);
    // alert(1);
    // html2canvas(document.getElementById(tableID), {
    //     onrendered: function (canvas) {
    //         var data = canvas.toDataURL();
    //         var docDefinition = {
    //             content: [{
    //                 image: data,
    //                 width: 500
    //             }]
    //         };
    //         pdfMake.createPdf(docDefinition).download(filename);
    //     }
    // });
}
