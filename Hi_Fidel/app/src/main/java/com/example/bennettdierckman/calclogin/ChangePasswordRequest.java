package com.example.bennettdierckman.calclogin;

import android.widget.EditText;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;

import java.util.HashMap;
import java.util.Map;

/**
 * Created by BennettDierckman on 2/8/18.
 */

public class ChangePasswordRequest extends StringRequest{
    //url that the php file is at
    private static final String CHANGE_PASSWRD_REQUEST_URL = "https://cgi.soic.indiana.edu/~team51/ChangePasswordRequest.php";
    //Binds the paramaters as assigned in loginActivity.java
    private Map<String, String> params;

    //Prepares android input to be sent to file location
    public ChangePasswordRequest(String newPassword, String username, Response.Listener<String> listener) {
        super(Request.Method.POST, CHANGE_PASSWRD_REQUEST_URL, listener, null);
        params = new HashMap<>();
        //assigns username from java file to new variable username that will be called in mysqli_escape(_POST['username'])
        params.put("newPassword", newPassword);
        params.put("username", username);
    }

    @Override
    public Map<String, String> getParams() {
        return params;
    }
}
