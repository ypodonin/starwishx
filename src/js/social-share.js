function copyWithFallback(text) {
  const textArea = document.createElement("textarea");

  textArea.value = text;
  textArea.setAttribute("readonly", "readonly");
  textArea.style.position = "absolute";
  textArea.style.left = "-9999px";

  document.body.appendChild(textArea);
  textArea.select();
  const isCopied = document.execCommand("copy");
  document.body.removeChild(textArea);

  if (!isCopied) {
    throw new Error("Fallback clipboard copy failed.");
  }
}

function writeToClipboard(text) {
  if (navigator.clipboard && window.isSecureContext) {
    return navigator.clipboard.writeText(text).catch(() => {
      copyWithFallback(text);
    });
  }

  return new Promise((resolve) => {
    copyWithFallback(text);
    resolve();
  });
}

function closeShareComponent(component) {
  const trigger = component.querySelector("[data-sw-social-share-trigger]");
  const panel = component.querySelector("[data-sw-social-share-panel]");
  const statusNode = component.querySelector("[data-sw-copy-status]");

  if (!trigger || !panel) {
    return;
  }

  trigger.setAttribute("aria-expanded", "false");
  panel.hidden = true;
  panel.classList.remove("has-status");

  if (statusNode) {
    statusNode.textContent = "";
    statusNode.classList.remove("is-visible");
  }
}

function closeAllShareComponents(exceptComponent = null) {
  document.querySelectorAll("[data-sw-social-share]").forEach((component) => {
    if (component !== exceptComponent) {
      closeShareComponent(component);
    }
  });
}

function initShareComponent(component) {
  const trigger = component.querySelector("[data-sw-social-share-trigger]");
  const panel = component.querySelector("[data-sw-social-share-panel]");
  const copyButton = component.querySelector("[data-sw-copy-button]");
  const statusNode = component.querySelector("[data-sw-copy-status]");

  let hintTimeout = 0;

  if (!trigger || !panel || !copyButton || !statusNode) {
    return;
  }

  trigger.addEventListener("click", () => {
    const isExpanded = trigger.getAttribute("aria-expanded") === "true";

    closeAllShareComponents(component);

    trigger.setAttribute("aria-expanded", String(!isExpanded));
    panel.hidden = isExpanded;

    if (!isExpanded) {
      copyButton.focus();
    }
  });

  copyButton.addEventListener("click", () => {
    const shareUrl = copyButton.getAttribute("data-copy-url") || "";
    const copiedLabel = copyButton.getAttribute("data-copied-label") || "";

    if (!shareUrl) {
      return;
    }

    writeToClipboard(shareUrl)
      .then(() => {
        window.clearTimeout(hintTimeout);
        panel.classList.add("has-status");
        statusNode.textContent = copiedLabel;
        statusNode.classList.add("is-visible");

        hintTimeout = window.setTimeout(() => {
          statusNode.textContent = "";
          statusNode.classList.remove("is-visible");
          panel.classList.remove("has-status");
        }, 2500);
      })
      .catch(() => {
        statusNode.textContent = "";
        statusNode.classList.remove("is-visible");
        panel.classList.remove("has-status");
      });
  });

  panel.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      closeShareComponent(component);
    });
  });
}

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-sw-social-share]").forEach(initShareComponent);

  document.addEventListener("click", (event) => {
    const activeComponent = event.target.closest("[data-sw-social-share]");

    closeAllShareComponents(activeComponent);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeAllShareComponents();
    }
  });
});
