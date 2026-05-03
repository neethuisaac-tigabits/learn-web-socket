// Echo.channel(`orders.${this.order.id}`)
//     .listen('OrderPlaced', (e) => {
//         console.log(e.order.bill_no);
//     });
Echo.channel(`updates`)
    .listen('OrderPlaced', (e) => {
        console.log('listening to updates channel');
        console.log(e.order.bill_no);
    });    