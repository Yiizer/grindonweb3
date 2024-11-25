<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')

    <style type="text/css">
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Light gray for the page background */
            color: #333; /* Dark text color */
        }

        .hero_area {
            background-color: white; /* Dark gray header */
        }

        /* Updated gray section background */
        .shop_section {
            padding: 80px 20px;
            background-color: white /* Dark gray background for the section */
            border-radius: 15px;
            box-shadow: 0px 12px 40px rgba(0, 0, 0, 0.2);
        }

        .heading_container {
            text-align: center;
            margin-bottom: 50px;
        }

        .heading_container h2 {
            font-size: 36px;
            font-weight: 700;
            color: black; /* White color for headings */
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .product-detail-card {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: white; /* Dark background for product card */
            border-radius: 12px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        /* Product Image */
        .product-image {
            flex: 1;
            text-align: center;
            border-radius: 12px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }

        .product-image:hover img {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
        /* Modal Styles */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Prevent scrolling */
            background-color: rgba(0, 0, 0, 0.9); /* Black background with transparency */
        }

        .modal-content {
            position: absolute;
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%);
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
        }

        .close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
            z-index: 1100;
        }

        .close-modal:hover,
        .close-modal:focus {
            color: #bbb;
        }

        /* Hide the header while modal is active */
        body.modal-open .hero_area {
            display: none;
        }


        /* Product Details */
        .product-details {
            flex: 2;
            padding: 20px;
        }

        .product-details h3 {
            font-size: 32px;
            color: #fff; /* White color for product title */
            font-weight: 600;
        }

        .product-details .price {
            font-size: 30px;
            font-weight: 700;
            color: #e74c3c; /* Red for price */
            margin-top: 15px;
        }

        .product-details .category,
        .product-details .quantity {
            font-size: 18px;
            color: black; /* Light gray for secondary text */
            margin-top: 12px;
        }

        .product-details .form-group {
            margin-top: 25px;
        }

        .product-details select,
        .product-details input[type="number"] {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border-radius: 6px;
            border: 1px solid #777; /* Darker gray border */
            font-size: 16px;
            background-color: #444; /* Darker background for inputs */
            color: #fff; /* White text color for inputs */
        }

        .product-description {
            background-color: #444;
            padding: 20px;
            border-radius: 8px;
            margin-top: 25px;
            font-size: 14px;
            color: white; /* Light gray text color */
        }

        /* Add to Cart Button */
        .add-to-cart-btn {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            padding: 14px 35px;
            font-size: 18px;
            color: #fff; /* White text for buttons */
            background-color: #555; /* Dark button background */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #444; /* Slightly darker button color on hover */
        }

        .btn-danger {
            background-color: #e74c3c; /* Red button for out of stock */
            cursor: not-allowed;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-detail-card {
                flex-direction: column;
                gap: 30px;
                padding: 20px;
            }

            .product-details h3 {
                font-size: 26px;
            }

            .product-details p {
                font-size: 14px;
            }

            .product-details .price {
                font-size: 24px;
            }

            .product-details select,
            .product-details input[type="number"] {
                padding: 12px;
                font-size: 15px;
            }

            .btn {
                padding: 12px 28px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="hero_area">
        @include('home.header')
    </div>

    <!-- Product Details Section -->
    <section class="shop_section">
        <div class="container">
            <div class="heading_container">
                <h2>Product Details</h2>
            </div>

            <div class="product-detail-card">
                <!-- Product Image -->
                <div class="product-image">
                    <img src="/products/{{$data->image}}" alt="{{ $data->title }}" id="productImage">
                </div>

                <!-- Product Details -->
                <div class="product-details">
                    <h3>{{ $data->title }}</h3>
                    <div class="product-description">
                        <p>{{ $data->description }}</p>
                    </div>

                    <p class="category"><strong>Category:</strong> {{ $data->category }}</p>
                    <p class="quantity"><strong>Available Quantity:</strong> {{ $data->quantity }}</p>

                    <div class="price">PHP {{ number_format($data->price, 2) }}</div>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('add.cart', $data->id) }}" method="POST">
                        @csrf

                        <!-- Size Selection -->
                        <div class="form-group">
                            <label for="size">Size</label>
                            <select name="size" id="size" required>
                                <option value="Small" {{ old('size') == 'Small' ? 'selected' : '' }}>Small</option>
                                <option value="Medium" {{ old('size') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="Large" {{ old('size') == 'Large' ? 'selected' : '' }}>Large</option>
                            </select>
                        </div>

                        <!-- Color Selection -->
                        <div class="form-group">
                            <label for="color">Color</label>
                            <select name="color" id="color" required>
                                <option value="Black" {{ old('color') == 'Black' ? 'selected' : '' }}>Black</option>
                                <option value="White" {{ old('color') == 'White' ? 'selected' : '' }}>White</option>
                            </select>
                        </div>

                        <!-- Quantity Selection -->
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $data->quantity }}" required>
                        </div>

                        <!-- Add to Cart Button -->
                        <div class="add-to-cart-btn">
                            @if ($data->quantity == 0)
                                <button type="button" class="btn btn-danger" disabled>Out of Stock</button>
                            @else
                                <button type="submit" class="btn">Add to Cart</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div id="imageModal" class="image-modal">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>
    <!-- Product Details Section End -->

    @include('home.footer')

    <script>
    // Get modal elements
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const productImage = document.getElementById('productImage');
    const closeModal = document.querySelector('.close-modal');
    const body = document.body;

    // Open the modal when the product image is clicked
    productImage.addEventListener('click', () => {
        modal.style.display = 'block';
        modalImage.src = productImage.src;
        body.classList.add('modal-open'); // Hide the header
    });

    // Close the modal when the close button is clicked
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
        body.classList.remove('modal-open'); // Show the header
    });

    // Close the modal when clicking outside the modal image
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            body.classList.remove('modal-open'); // Show the header
        }
    });
</script>


</body>

</html>
