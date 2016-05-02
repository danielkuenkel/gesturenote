function checkStorage() {
    if (getLocalItem(PROJECT_PHASE_STEPS) && getLocalItem(PROJECT_PHASE_STEPS).length > 0) {
        console.log('there are phase steps');
    } else {
        console.log('there are no phase steps');
    }
}