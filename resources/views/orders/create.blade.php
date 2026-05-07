<x-layout>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Create New Order</h1>
                <form method="post" action="/orders">
                    @csrf
                    <label>Name</label>
                    <input type="text" name="name"><br>
                    <label>Amount</label>
                    <input type="number" name="amount"><br>
                    <label>Bill No.</label>
                    <input type="text" name="bill_no"><br>                    
                    <input type="submit" class="btn-generic" value="Create Now">
                </form>
            </div>
        </div>
    <div>
</x-layout>