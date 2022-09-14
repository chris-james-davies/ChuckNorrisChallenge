import * as React from "react";

export default function StepTwo(props) {
    const emails = props.emails;
    const confirmJokeRequest = props.confirmJokeRequest;

    return (
        <div className="card">
            Here is the list of emails you want to send jokes to. Please check them over and then confirm.
            <ul>
                {emails.map((email) => (
                    <li>{email}</li>
                ))}
            </ul>
            <button onClick={confirmJokeRequest}>Send the Jokes!</button>
        </div>
    );
}
