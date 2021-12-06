@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    {!! !is_null($product) ? 'Update Product <span class="product-header-title">' . $product->title . '</span>' : 'New Product' !!}
                </div>

                <div class="card-body">

                    <form action="{{ (!is_null($product)) ? route('update-product') : route('new-product')}}" method="POST" class="row">
                        @csrf

                        @if (!is_null($product))
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @endif

                        <div class="form-group col-md-12">
                            <label for="product_title">Product Title</label>
                            <input type="text" class="form-control" id="product_title" name="product_title" placeholder="Product Title" required value="{{ !is_null($product) ? $product->title : '' }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="product_description">Product Description</label>
                            <textarea placeholder="Product Description"  required class="form-control" name="product_description" id="product_description" cols="30" rows="10">{{ !is_null($product) ? $product->description : '' }}</textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="product_category">Product Category</label>
                            <select class="form-control" name="product_category" id="product_category" required>
                                <option value="">Select A Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ !is_null($product) && $product->category->id === $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>

                        </div>


                        <div class="form-group col-md-12">
                            <label for="product_unit">Product Unit</label>
                            <select class="form-control" name="product_unit" id="product_unit" required>
                                <option value="">Select A Unit</option>
                                @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ !is_null($product) && $product->hasUnit->id === $unit->id ? 'selected' : '' }}>
                                    {{ $unit->formatted() }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-6">
                            <label for="product_price">Product Price</label>
                            <input type="number" step="any" class="form-control" id="product_price" name="product_price" placeholder="Product Price" required value="{{ !is_null($product) ? $product->price : '' }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="product_discount">Product Discount</label>
                            <input type="number" step="any" class="form-control" id="product_discount" name="product_discount" placeholder="Product Discount" required value="{{ !is_null($product) ? $product->discount : 0 }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="product_total">Product Total</label>
                            <input type="number" step="any" class="form-control" id="product_total" name="product_total" placeholder="Product Price" required value="{{ !is_null($product) ? $product->total : '' }}">
                        </div>

                        {{-- Options --}}
                        <table id="options-table" class="table table-striped">


                        </table>
                        <div class="form-group col-md-12">
                            <a class="btn btn-outline-dark add-option-btn" href="#">Add Option</a>

                        </div>
                        {{-- /Options --}}


                            <div class="form-group col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary btn-block">
                                    Save
                                </button>
                            </div>




                    </form>


                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal options-window" tabindex="-1" role="dialog" id="options-window">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body row">


                <div class="form-group col-md-6">
                    <label for="option_name">Option Name</label>
                    <input type="text" class="form-control" id="option_name" name="option_name" placeholder="Option Name" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="option_value">Option Value</label>
                    <input type="text" class="form-control" id="option_value" name="option_value" placeholder="Option Value" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary add-option-button">Add Option</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>


        </div>
    </div>


</div>
@endsection


@section('scripts')

<script>
    $(document).ready(function() {
        var $optionNameList = [];
        var $optionWindow = $('#options-window');
        var $addOptionbtn = $('.add-option-btn');
        var $optionsTable = $('#options-table');
        var optionNamesRow = '';

        $addOptionbtn.on('click', function(e) {
            e.preventDefault();
            $optionWindow.modal('show');
        });

        $(document).on('click', '.remove-option', function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });

        $(document).on('click', '.add-option-button', function(e) {
            e.preventDefault();
            var $optionName = $('#option_name');
            if ($optionName.val() === '') {

                alert('Option Name is Required');
                return false;
            }
            var $optionValue = $('#option_value');
            if ($optionValue.val() === '') {

                alert('Option Value is Required');
                return false;
            }


            if(!$optionNameList.includes($optionName.val())){
                 $optionNameList.push($optionName.val());
                 optionNamesRow = '<td><input type="hidden" name="options[]" value="'+$optionName.val()+'"></td>';
            }




            var optionRow = `
            <tr>
            <td>
                ` + $optionName.val() + `
            </td>
            <td>
                ` + $optionValue.val() + `
            </td>

            <td>
                <a href="" class="remove-option"><i class="fas fa-trash"></i></a>
                <input type="hidden" name="` + $optionName.val() + `[]" value="` + $optionValue.val() + `">
            </td>
            </tr>`;

            $optionsTable.append(
                optionRow
            );

            $optionsTable.append(
                optionNamesRow
            );



            $optionValue.val('');

        });
    });
</script>

@endsection
