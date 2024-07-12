<div class="filter-container">
    
    <div class="filter-form" id="filter-form">
        <form method="POST">
            <h3>Filter Posts</h3>
            <label for="type">Type:</label>
            <select name="type" id="type">
                <option value="">All Types</option>
                <option value="One Seat">One Seat</option>
                <option value="One Room">One Room</option>
                <option value="Full Flat">Full Flat</option>
            </select>

            <label for="price-range">Price Range:</label>
            <input type="number" name="min_price" placeholder="Min Price" min="0">
            <input type="number" name="max_price" placeholder="Max Price" min="0">

            <label for="persons">Number of Persons:</label>
            <input type="number" name="persons" min="1" placeholder="Number of Persons">

            <label>Facilities:</label>
            <label><input type="checkbox" name="facilities[]" value="WiFi"> WiFi</label>
            <label><input type="checkbox" name="facilities[]" value="Washroom"> Washroom</label>
            <label><input type="checkbox" name="facilities[]" value="Balcony"> Balcony</label>
            <label><input type="checkbox" name="facilities[]" value="Maid"> Maid</label>
            <label><input type="checkbox" name="facilities[]" value="Parking"> Parking</label>
            <label><input type="checkbox" name="facilities[]" value="Lift"> Lift</label>
            <label><input type="checkbox" name="facilities[]" value="Water Filter"> Water Filter</label>
            <label><input type="checkbox" name="facilities[]" value="Security"> Security</label>

            <label for="area">Area:</label>
            <input type="text" name="area" placeholder="Area">

            <label for="road_no">Road No:</label>
            <input type="text" name="road_no" placeholder="Road No">

            <label for="house_no">House No:</label>
            <input type="text" name="house_no" placeholder="House No">

            <button type="submit">Apply Filters</button>
        </form>
    </div>
</div>

