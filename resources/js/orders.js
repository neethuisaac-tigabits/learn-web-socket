Echo.channel(`orders.1`)
    .listen('OrderPlaced', (e) => {
        console.log(e.order.bill_no);
    });
Echo.channel(`updates`)
    .listen('OrderPlaced', (e) => {
        console.log('listening to updates channel');
        console.log(e.order.bill_no);
        document.getElementById('notification').innerHTML = `Amount:${e.order.amount}`;
    });
console.log("orders.js");