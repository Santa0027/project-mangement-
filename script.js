// document.addEventListener("DOMContentLoaded", function () {
//     const ClientPage = document.getElementById("ClientPage");

//     // Load the client page on click
//     if (ClientPage) {
//         ClientPage.addEventListener("click", function () {
//             loadClientPage();
//         });
//     } else {
//         console.error("ClientPage button not found. Ensure the element exists and has the correct ID.");
//     }

//     function loadClientPage() {
//         fetch("add-client.php") // Replace with your actual client template file
//             .then((response) => {
//                 if (!response.ok) {
//                     throw new Error(`Failed to load client template: ${response.statusText}`);
//                 }
//                 return response.text();
//             })
//             .then((html) => {
//                 const mainContent = document.querySelector(".main-content");
//                 if (mainContent) {
//                     mainContent.innerHTML = html;
//                     fetchClients(); // Fetch and display client data after loading the template
//                 } else {
//                     console.error("Element with class 'main-content' not found.");
//                 }
//             })
//             .catch((error) => console.error("Error loading client page:", error));
//     }

//     function fetchClients() {
//         fetch("add-client.php") // Replace with your actual client-fetching PHP endpoint
//             .then((response) => {
//                 if (!response.ok) {
//                     throw new Error(`Failed to fetch clients: ${response.statusText}`);
//                 }
//                 return response.json();
//             })
//             .then((data) => {
//                 const tableBody = document.querySelector("#client-table tbody");
//                 if (!tableBody) {
//                     console.error("Table body for clients not found.");
//                     return;
//                 }
//                 tableBody.innerHTML = ""; // Clear existing rows

//                 if (data.success) {
//                     data.clients.forEach(client => {
//                         const row = `
//                             <tr>
//                                 <td>${client.id}</td>
//                                 <td>${client.cname}</td>
//                                 <td>${client.cemail}</td>
//                                 <td>${client.cphone}</td>
//                                 <td>${client.caddress}</td>
//                             </tr>
//                         `;
//                         tableBody.innerHTML += row;
//                     });
//                 } else {
//                     tableBody.innerHTML = `<tr><td colspan="5">${data.error}</td></tr>`;
//                 }
//             })
//             .catch((error) => console.error("Error fetching clients:", error));
//     }
// });
