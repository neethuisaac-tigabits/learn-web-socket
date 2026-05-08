<x-layout>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h1>Create New Order</h1>
                <form method="post" action="/orders">
                    @csrf
                    <label for="name" class="form-label">Name</label>
                    <input class="form-control" type="text" name="name"><br>
                    <label class="form-label">Amount</label>
                    <input class="form-control" type="number" name="amount"><br>
                    <label class="form-label">Bill No.</label>
                    <input class="form-control" type="text" name="bill_no"><br>                    
                    <input type="submit" class="btn-generic" value="Create Now">
                </form>
            </div>
        </div>
    <div>
</x-layout>