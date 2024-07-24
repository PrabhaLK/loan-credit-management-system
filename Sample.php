<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hide Part of Page</title>
    <style>
        #content {
            display: block;
            margin: 20px;
            padding: 20px;
            border: 1px solid #000;
        }
    </style>
</head>
<body>

<div id="content">
    This is the content that will be hidden.
</div>
<button id="toggleButton">Hide Content</button>

<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        var content = document.getElementById('content');
        if (content.style.display === "none") {
            content.style.display = "block";
            this.textContent = "Hide Content";
        } else {
            content.style.display = "none";
            this.textContent = "Show Content";
        }
    });
</script>

</body>
</html>

<td class="text-right h5" id="test_total_cost">Rs 0.00</td> <!-- Placeholder for total cost -->
</tr>';
