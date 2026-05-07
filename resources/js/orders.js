let orderId = document.getElementById('orderId').value;
// Listen on the private channel "orders.{order_id}"
Echo.private(`orders.${orderId}`)
    .listen('OrderChanged', (e) => {        
        console.log(e.order.bill_no);
         document.getElementById('notification').innerHTML = `Amount:${e.order.amount}`;
    });
// Listen on the public channel "updates".
Echo.channel(`updates`)
    .listen('OrderChanged', (e) => {
        console.log('listening to updates channel');
        console.log(e.order.bill_no);
        document.getElementById('notification').innerHTML = `Amount:${e.order.amount}`;
        console.log('notif content changed');
    });
console.log("orders.js");