let orderId = document.getElementById('orderId').value;
Echo.private(`orders.${orderId}`)
    .listen('OrderPlaced', (e) => {        
        console.log(e.order.bill_no);
         document.getElementById('notification').innerHTML = `Amount:${e.order.amount}`;
    });
Echo.channel(`updates`)
    .listen('OrderPlaced', (e) => {
        console.log('listening to updates channel');
        console.log(e.order.bill_no);
        document.getElementById('notification').innerHTML = `Amount:${e.order.amount}`;
        console.log('notif content changed');
    });
console.log("orders.js");