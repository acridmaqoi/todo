<?php

class Form {

    private $title;
    private $fields = array();
    private $button_title;

    function __construct($title) {
        $this->$title = $title;
    }

    function add_field(string $id, string $placeholder) {
        $field = new Field($id, $placeholder);
        array_push($this->button_title, $field);
    }

    function set_button_title($button_title) {
        $this->$button_title = $button_title;
        
    }

    function generate() {

        echo "<p>".$this->title."</p>";
        echo "<div class='form'>";
        foreach($this->fields as $field) {
            echo "<input placeholder=".$field->placeholder." id=".$field->id." spellcheck='false'>";
        }
        echo "<button type='submit' id='btn-submit'>".$this->button_title."</button>";
        echo "</div>";

        echo "<script>

        // allows enter button to be used when submitting form
        document.querySelector('#email_confirm').addEventListener('keyup', event => {
            if(event.key !== 'Enter') return;
            document.querySelector('#btn-submit').click();
            event.preventDefault();
        });

        const form = {
            email: document.getElementById('email'),
            email_confirm: document.getElementById('email_confirm'),
            submit: document.getElementById('btn-submit'),
            messages: document.getElementById('form-messages')
        };

        form.submit.addEventListener('click', () => {
            console.log('confirming email...')

            const request = new XMLHttpRequest();

            request.onload = () => {
                let responseObject = null;

                try {
                    // response json from server
                    responseObject = JSON.parse(request.responseText)
                } catch (e) {
                    console.error('Could not parse JSON!')
                }

                if (responseObject) {
                    handleResponse(responseObject)
                }
            };

            const requestData = 'email=${form.email.value}&email_confirm=${form.email_confirm.value}';

            // send to server
            request.open('post', 'change_email.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(requestData);
        });

        function handleResponse(responseObject) {
            //prevents duplicate messages
            while (form.messages.firstChild) {
                form.messages.removeChild(form.messages.firstChild);
            }

            if (responseObject.ok) {
                const li = document.createElement('p');
                li.textContent = 'Check your email for a verification link';
                form.messages.append(li);
            } else {
                responseObject.messages.forEach((message) => {
                    const li = document.createElement('p');
                    console.log(message)
                    li.textContent = message;
                    form.messages.appendChild(li);
                });
            }
        }
    </script>";
    }    
}

class Field {
    public $id;
    public $placeholder;

    function __construct($id, $placeholder) {
        $this->$id = $id;
        $this->$placeholder = $placeholder;
    }
}