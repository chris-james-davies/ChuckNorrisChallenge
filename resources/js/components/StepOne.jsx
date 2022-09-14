import * as React from "react";
import { useState } from "react";

export default function StepOne(props) {
    const emails = props.emails;
    const setEmails = props.setEmails;
    const submitJokeRequest = props.submitJokeRequest;

    function emailInputs() {
        return emails.map((email, index) => (
            <div>
                <label htmlFor="email">Email {index + 1}: </label>
                <input
                    type="text"
                    name="email"
                    placeholder="Enter an email address"
                    value={email}
                    index={index}
                    onChange={handleChange}
                ></input>
                {index != 0 ? (
                    <button relatedIndex={index} onClick={removeEmail}>
                        X
                    </button>
                ) : (
                    ""
                )}
            </div>
        ));
    }

    const handleChange = (event) => {
        let index = event.target.getAttribute("index");
        let newEmails = [...emails];
        newEmails[index] = event.target.value;
        setEmails(newEmails);
    };

    const removeEmail = (event) => {
        let index = parseInt(event.target.getAttribute("relatedIndex"));
        let newEmails = emails.filter((email, id) => id !== index);
        setEmails(newEmails);
    };

    const addEmail = () => {
        setEmails((emails) => [...emails, ""]);
    };

    return (
        <div>
            <div>
                <p>
                    Enter email addresses below to receive your very own
                    personalised Chuck Norris jokes.
                </p>
            </div>
            <div className="card">{emailInputs()}</div>
            <button onClick={addEmail}>Add another Email</button>
            <button onClick={submitJokeRequest}>Request Jokes</button>
        </div>
    );
}
