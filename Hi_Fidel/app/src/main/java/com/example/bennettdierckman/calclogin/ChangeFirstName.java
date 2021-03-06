package com.example.bennettdierckman.calclogin;


import android.app.AlertDialog;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;


/**
 * A simple {@link Fragment} subclass.
 */
public class ChangeFirstName extends Fragment {


    public ChangeFirstName() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_change_first_name, container, false);
        Bundle bundle = getArguments();
        final String username = bundle.getString("username");
        final String password = bundle.getString("password");
        Log.d("Change First Name bundl", String.valueOf(bundle));

        final EditText etNewFirstName = view.findViewById(R.id.etNewFirstName);
        Button bSaveChanges = view.findViewById(R.id.bNext);
        Button bGoBack = view.findViewById(R.id.bReturn2Party);

        bSaveChanges.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String newFirstName = etNewFirstName.getText().toString();

                if ((newFirstName.isEmpty())||(!newFirstName.matches("(?!.*/)[A-Za-z][A-Za-z]{0,18}[A-Za-z]"))) {
                    AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
                    builder.setMessage("Invalid First Name")
                            .setNegativeButton("Retry", null)
                            .create()
                            .show();
                }else {
                    //Response listener to handle response from php file
                    Response.Listener<String> responseListener = new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            try {
                                // Gets Response array from php
                                JSONObject jsonResponse = new JSONObject(response);
                                //Assign values of $response['email'] and $response['username'] to java boolean variables
                                boolean success = jsonResponse.getBoolean("success");
                                //Conditionals with statements that either register the user, or inform them the email or username is taken
                                if (success) {
                                    Toast.makeText(getActivity().getApplicationContext(), "First Name updated", Toast.LENGTH_LONG).show();
                                    //Create new bundle for Profile fragment
                                    Bundle bundle = new Bundle();
                                    bundle.putString("username", username);
                                    bundle.putString("password", password);
                                    //Begin fragment transacion
                                    android.support.v4.app.FragmentManager fragmentManager = getActivity().getSupportFragmentManager();
                                    android.support.v4.app.FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();
                                    //Create new instance of Profile fragment
                                    EditProfile editProfile = new EditProfile();
                                    editProfile.setArguments(bundle);
                                    //Finish fragment transaction
                                    fragmentTransaction.replace(R.id.flcontent, editProfile);
                                    fragmentTransaction.commit();
                                } else {  //(emailSuccess)
                                    AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
                                    builder.setMessage("First Name too long")
                                            .setNegativeButton("Retry", null)
                                            .create()
                                            .show();
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                    };
                    //prepares CreateRequest with the appropriate data, so that the php file cann be called and the party can
                    //be added to the database
                    ChangeFirstNameRequest changeFirstNameRequest = new ChangeFirstNameRequest(newFirstName, username, responseListener);
                    RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
                    queue.add(changeFirstNameRequest);
                }
            }
        });
        bGoBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Bundle bundle = new Bundle();
                //Set the bundle arguments
                bundle.putString("username", username);
                bundle.putString("password", password);

                //Begin Fragment transaction
                android.support.v4.app.FragmentManager fragmentManager = getActivity().getSupportFragmentManager();
                android.support.v4.app.FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();
                //Create new profile instance
                EditProfile editProfile = new EditProfile();
                //Set bundle arguments
                editProfile.setArguments(bundle);
                //Finish fragment transaction
                fragmentTransaction.replace(R.id.flcontent, editProfile);
                fragmentTransaction.commit();
            }
        });
        return view;
    }

}
