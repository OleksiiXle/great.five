<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" id="url" class="form-control" placeholder="URL...">
                    </div>
                    <div class="checkbox">
                        <label for="checkTitle">
                            <input type="checkbox" id="checkTitle" name="checkTitle" >
                            Title
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="checkDescription">
                            <input type="checkbox" id="checkDescription" name="checkDescription">
                            Description
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="checkLinks">
                            <input type="checkbox" id="checkLinks" name="checkLinks">
                            Number of links
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="checkH1">
                            <input type="checkbox" id="checkH1" name="checkH1">
                            H1
                        </label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-info" onclick="send()">
                        Send
                    </button>
                    <button class="btn btn-danger" onclick="">
                        Clear
                    </button>

                </div>
            </div>

        </div>
        <div class="col-md-9">

        </div>
    </div>
</div>

</body>

<script>
    function send() {
        let data = [];
        let url = '/adminx/user/test-ajax';
       // window.location.href + 'gitSearch.php';
      //  console.log($('#checkH1').prop('checked'));
        if ($('#url').val().length > 0){
            data['url'] = $('#url').val();
        } else {
            alert('URL is empty');
            return false;
        }
        let checked = false;
        $('input[type=checkbox]').each(function () {
            if ($(this).prop('checked')) {
                data[$(this).attr('name')] = '1';
                checked = true;
            }
        });
        if (!checked){
            alert('Check something');
            return false;
        }
        console.log(data);
        return $.ajax({
            url: url,
            type: "POST",
            data: {
                'url' : $('#url').val(),
                'checkTitle' : $('#checkTitle').prop('checked'),
                'checkDescription' : $('#checkDescription').prop('checked'),
                'checkLinks' : $('#checkLinks').prop('checked'),
                'checkH1' : $('#checkH1').prop('checked'),
            },
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response['status']){
                    alert('ok');

                } else {
                    alert(response['data']);
                    console.log(response['data']);
                }
            },
            error: function (jqXHR, error, errorThrown) {
                console.log( "error: " + error + " " +  errorThrown);
                console.log(jqXHR)
            }
        });

    }

</script>
