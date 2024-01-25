$.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "No space please and don't leave it empty");

$("#condolence-form").validate({

 rules: {

        FirstName: {
          required: true,
          noSpace: true

        } ,

        LastName: "required",

        Description: "required",

        Relation:"required",

        City:"required",

        State:"required",

        Email: {

          required: true,

          email: true

        },

        

        //agree: "required"

      },

      messages: {

        FirstName: "Please enter your firstname",

        LastName: "Please enter your lastname",

        Description:"Please enter your Description",

        Relation: "Please enter your Relationship",

        City: "Please enter your City",

        State: "Please enter your State",

        email: "Please enter a valid email address"

        //agree: "Please accept our policy",

        //topic: "Please select at least 2 topics"

      }

    });

$("#add_obituaries").validate({

      rules: {

        Obituaries_name: "required",

       ObituariesDate: "required",

        description:"required"

      

        //agree: "required"

      },

      messages: {

        Obituaries_name: "Please enter your Name",

        ObituariesDate:"Please enter your Date",

        description: "Please enter your Description"

        //agree: "Please accept our policy",

        //topic: "Please select at least 2 topics"

      }

    });
$("#contact-us").validate({

      rules: {

        user_name: "required",

        Email_id: {
                required: true,
                email: true
            },

        subject: "required",

        message:"required"

      

        //agree: "required"

      },

      messages: {

        user_name: "Please enter your Name",
       subject:"Please enter your subject",

        message: "Please enter your Message",
        Email_id: "Please enter a valid email address"

        //agree: "Please accept our policy",

        //topic: "Please select at least 2 topics"

      }

    });
