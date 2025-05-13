// Notification Functions
function addNotification(message) {
  const timestamp = new Date().toLocaleString();
  notifications.push("[" + timestamp + "] " + message);
  displayNotifications();
}

function displayNotifications() {
  let html = "";
  notifications.forEach(msg => {
    html += "<p>" + msg + "</p>";
  });
  document.getElementById("notificationOutput").innerHTML = html;
}

// Initialize notifications module
document.addEventListener('DOMContentLoaded', function() {
  const notificationOutput = document.getElementById("notificationOutput");
  if (notificationOutput) {
    notificationOutput.innerHTML = "<p>Notifications will appear here.</p>";
  }
}); 