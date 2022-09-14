import * as React from "react";
import StepOne from "./StepOne";
import StepTwo from "./StepTwo";
import axios from "axios";

export default function ChuckApp() {
    const [step, setStep] = React.useState(1);
    const [emails, setEmails] = React.useState([""]);
    const [requestId, setRequestId] = React.useState([""]);

    const baseURL = "/ajax/joke";

    const submitJokeRequest = (event) => {
        axios
            .post(`${baseURL}/request`, {
                emails: emails,
            })
            .then((response) => {
                if (response.data.success === true) {
                    setStep(2);
                    setRequestId(response.data.data.request_id);
                    setEmails(response.data.data.emails);
                } else {
                    // Handle Errors
                }
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const confirmJokeRequest = (event) => {
        axios
            .post(`${baseURL}/confirm`, {
                id: requestId,
            })
            .then((response) => {
                if (response.data.success === true) {
                    setStep(3);
                } else {
                    // Handle Errors
                }
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const goAgain = () => {
        setEmails([""]);
        setStep(1);
    }

    return (
        <div className="App">
            <div></div>
            <h1>Chuck Norris - Joke Generator</h1>
            {step === 1 ? (
                <StepOne
                    emails={emails}
                    submitJokeRequest={submitJokeRequest}
                    setEmails={setEmails}
                />
            ) : (
                ""
            )}
            {step === 2 ? (
                <StepTwo
                    emails={emails}
                    confirmJokeRequest={confirmJokeRequest}
                />
            ) : (
                ""
            )}
            {step === 3 ? (
                <div>
                    <h1>Done!</h1>
                    <button onClick={goAgain}> Reset</button>
                </div>
            ) : (
                ""
            )}
        </div>
    );
}
