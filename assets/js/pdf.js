window.onload = function () {
    document.getElementById("download")
        .addEventListener("click", () => {
            const invoice = this.document.getElementById("invoice");
            console.log(invoice);
            console.log(window);
            var file=window.location.pathname.split('/').pop();
            //alert(window.location.pathname.split('/').slice(-4)[0]);

            var a = window.location.pathname.split('/').slice(-4)[0];
                if(a=='sales_quote'){
                   file=window.location.pathname.split('/').slice(-2)[0];  

                   var version_no=window.location.pathname.split('/').slice(-1)[0];  
                   file = file+"_REV_"+version_no;
                }

            var opt = {
                margin: 0.75,
                filename: file+'.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(invoice).set(opt).save();
        })
}