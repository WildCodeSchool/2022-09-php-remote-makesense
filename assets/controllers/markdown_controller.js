import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['preview']
    connect() {
        this.previewTarget.innerHTML = "connected"
    }

    comment(event) {
        this.previewTarget.innerHTML = event.currentTarget.value;
    }
}
